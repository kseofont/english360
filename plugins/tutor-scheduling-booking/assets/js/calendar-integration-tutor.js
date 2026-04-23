/**
 * Integration with Tutor Calendar Addon (React-based)
 * Adds booking events to the calendar and handles clicks
 */

(function($) {
	'use strict';
	
	// Wait for Tutor Calendar React component to load
	var calendarReady = false;
	var checkInterval = setInterval(function() {
		var $wrapper = $('#tutor_calendar_wrapper');
		if ($wrapper.length && $wrapper.find('.tutor-calendar-day').length > 0) {
			calendarReady = true;
			clearInterval(checkInterval);
			setupCalendarIntegration();
		}
	}, 500);
	
	// Stop checking after 15 seconds
	setTimeout(function() {
		clearInterval(checkInterval);
	}, 15000);
	
	function setupCalendarIntegration() {
		// Handle clicks on calendar days (for students to book)
		$(document).on('click', '.tutor-calendar-day:not(.space)', function(e) {
			// Only allow booking for students (not teachers)
			if (tutorScheduling.userRole === 'tutor_instructor') {
				return; // Teachers can't book, they approve
			}
			
			// Don't trigger if clicking on an event
			if ($(e.target).closest('.tutor-event-wrapper').length) {
				return;
			}
			
			var $day = $(this);
			var dayText = $day.text().trim();
			var dayNumber = parseInt(dayText);
			
			if (isNaN(dayNumber) || dayNumber === 0) {
				return;
			}
			
			// Get month and year from calendar
			var monthText = $('#tutor-c-calendar-month').text().trim();
			var yearText = $('#tutor-c-calendar-year').text().trim();
			
			// Try to get from dropdowns
			var $monthOption = $('.tutor-calendar-dropdown-current-month');
			var $yearOption = $('.tutor-calendar-dropdown-current-year');
			var month = $monthOption.length ? parseInt($monthOption.data('value')) : null;
			var year = $yearOption.length ? parseInt($yearOption.data('value')) : null;
			
			// Parse from text if dropdowns not available
			if (month === null && monthText) {
				var months = ['January', 'February', 'March', 'April', 'May', 'June', 
				              'July', 'August', 'September', 'October', 'November', 'December'];
				month = months.indexOf(monthText);
			}
			
			if (!year && yearText) {
				year = parseInt(yearText);
			}
			
			if (month !== null && month >= 0 && year) {
				// Month is 0-based in JS, convert to 1-based for date string
				var date = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(dayNumber).padStart(2, '0');
				
				// Check if date is in the past
				var today = new Date();
				today.setHours(0, 0, 0, 0);
				var selectedDate = new Date(date + 'T00:00:00');
				
				if (selectedDate >= today) {
					// Show booking modal
					showBookingModalFromCalendar(date);
				}
			}
		});
		
		// Handle clicks on booking events to show details
		// Tutor Calendar renders events, so we need to intercept clicks on our booking events
		$(document).on('click', '.tutor-event-wrapper', function(e) {
			var $event = $(this);
			var $link = $event.find('a');
			var href = $link.attr('href');
			
			// Check if this is a booking event by checking the href or post_type
			// Booking events have href='#' and contain "Lesson with" in title
			if (href === '#' || href === '#tutor-booking') {
				var eventTitle = $event.find('span').text();
				if (eventTitle && (eventTitle.indexOf('Lesson with') !== -1 || eventTitle.indexOf('Lesson:') !== -1)) {
					e.preventDefault();
					
					// Try to get booking ID from data attribute or extract from event
					var bookingId = $event.data('booking-id');
					
					// If not found, try to extract from the event listing
					if (!bookingId) {
						var $listing = $event.closest('.tutor-event-listing');
						if ($listing.length) {
							// Try to find booking ID in the event data
							// We'll need to store it when events are rendered
							var eventDate = $listing.find('.icon-wrapper span').text();
							// For now, show a message that details can be viewed in bookings page
							alert('Click on "My Bookings" in the dashboard to view lesson details.');
							return;
						}
					}
					
					if (bookingId) {
						showBookingDetailsModal(bookingId);
					}
				}
			}
		});
	}
	
	// Show booking modal (reuse function from calendar-booking.js if available)
	function showBookingModalFromCalendar(date) {
		if (typeof showBookingModal !== 'undefined') {
			showBookingModal(date);
		} else {
			// Fallback: load available teachers
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_get_available_teachers',
					nonce: tutorScheduling.nonce,
					date: date
				},
				success: function(response) {
					if (response.success && response.data.teachers.length > 0) {
						// Trigger booking modal from calendar-booking.js
						if (typeof createBookingModal !== 'undefined') {
							var modal = createBookingModal(date, response.data.teachers);
							$('body').append(modal);
							$('#tutor-booking-modal').fadeIn();
						} else {
							alert('Please use the booking form to schedule a lesson.');
						}
					} else {
						alert('No available teachers for this date.');
					}
				}
			});
		}
	}
	
	// Show booking details modal
	function showBookingDetailsModal(bookingId) {
		$.ajax({
			url: tutorScheduling.ajaxurl,
			type: 'POST',
			data: {
				action: 'tutor_scheduling_get_booking_details',
				nonce: tutorScheduling.nonce,
				booking_id: bookingId
			},
			success: function(response) {
				if (response.success) {
					var data = response.data;
					var modal = createBookingDetailsModalHTML(data);
					$('body').append(modal);
					$('#tutor-booking-details-modal').fadeIn();
				}
			}
		});
	}
	
	// Create booking details modal HTML
	function createBookingDetailsModalHTML(data) {
		var booking = data.booking;
		var student = data.student;
		var teacher = data.teacher;
		var course = data.course;
		var lesson = data.lesson;
		
		var modalHtml = '<div id="tutor-booking-details-modal" class="tutor-modal-overlay">' +
			'<div class="tutor-modal-content">' +
				'<span class="tutor-modal-close">&times;</span>' +
				'<h2>Lesson Details</h2>' +
				'<div class="tutor-booking-details">' +
					'<div class="booking-detail-row">' +
						'<strong>Date:</strong> ' + formatDate(booking.date) +
					'</div>' +
					'<div class="booking-detail-row">' +
						'<strong>Time:</strong> ' + formatTime(booking.time) +
					'</div>' +
					'<div class="booking-detail-row">' +
						'<strong>Duration:</strong> ' + booking.duration + ' minutes' +
					'</div>' +
					'<div class="booking-detail-row">' +
						'<strong>Teacher:</strong> ' + teacher.name + ' (' + teacher.email + ')' +
					'</div>' +
					'<div class="booking-detail-row">' +
						'<strong>Student:</strong> ' + student.name + ' (' + student.email + ')' +
					'</div>' +
					'<div class="booking-detail-row">' +
						'<strong>Course:</strong> ' + course.title +
					'</div>';
		
		if (lesson) {
			modalHtml += '<div class="booking-detail-row">' +
				'<strong>Lesson:</strong> ' + lesson.title +
			'</div>';
		}
		
		if (booking.google_meet_link) {
			modalHtml += '<div class="booking-detail-row">' +
				'<strong>Google Meet:</strong> ' +
				'<a href="' + booking.google_meet_link + '" target="_blank" class="tutor-btn tutor-btn-sm" style="margin-left: 10px;">' +
					'Join Meeting' +
				'</a>' +
			'</div>';
		}
		
		if (booking.notes) {
			modalHtml += '<div class="booking-detail-row">' +
				'<strong>Notes:</strong> ' + booking.notes +
			'</div>';
		}
		
		modalHtml += '</div>' +
				'<div class="tutor-modal-actions">' +
					'<button class="tutor-btn tutor-btn-secondary tutor-modal-close">Close</button>' +
				'</div>' +
			'</div>' +
		'</div>';
		
		return modalHtml;
	}
	
	// Format date
	function formatDate(dateStr) {
		if (!dateStr) return '';
		var date = new Date(dateStr + 'T00:00:00');
		if (isNaN(date.getTime())) {
			return dateStr;
		}
		return date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
	}
	
	// Format time
	function formatTime(timeStr) {
		if (!timeStr) return '';
		var time = timeStr.substring(0, 5);
		return time;
	}
	
	// Close modal handler
	$(document).on('click', '.tutor-modal-close, .tutor-modal-overlay', function(e) {
		if (e.target === this || $(e.target).hasClass('tutor-modal-close')) {
			$('#tutor-booking-details-modal').fadeOut(function() {
				$(this).remove();
			});
		}
	});
	
})(jQuery);

