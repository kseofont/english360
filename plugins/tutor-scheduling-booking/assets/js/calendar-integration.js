/**
 * Calendar Integration for Tutor Scheduling
 * Integrates with Tutor Calendar React component
 * Adds booking events and handles date clicks for booking
 */

(function($) {
	'use strict';
	
	// Intercept Tutor Calendar fetch requests and add our bookings
	var originalFetch = window.fetch;
	window.fetch = function(url, options) {
		if (options && options.method === 'POST' && options.body instanceof FormData) {
			var action = options.body.get('action');
			if (action === 'get_calendar_materials') {
				return originalFetch.apply(this, arguments).then(function(response) {
					// Clone response to read it without consuming it
					return response.clone().json().then(function(data) {
						// Add our bookings to the response
						if (data.success && data.data && data.data.response) {
							addBookingsToResponse(data);
						}
						// Return modified response as a new Response object
						return new Response(JSON.stringify(data), {
							status: response.status,
							statusText: response.statusText,
							headers: {
								'Content-Type': 'application/json'
							}
						});
					}).catch(function(err) {
						// If JSON parsing fails, return original response
						return response;
					});
				});
			}
		}
		return originalFetch.apply(this, arguments);
	};
	
	// Add bookings to calendar response
	function addBookingsToResponse(data) {
		// Get month and year from the request or current display
		var month = null;
		var year = null;
		
		// Try to get from DOM (Tutor Calendar React component)
		var monthElement = document.getElementById('tutor-c-calendar-month');
		var yearElement = document.getElementById('tutor-c-calendar-year');
		
		if (monthElement && yearElement) {
			// Get from data attribute or innerHTML
			month = parseInt(monthElement.dataset.value || monthElement.getAttribute('data-value') || new Date().getMonth()) + 1;
			year = parseInt(yearElement.innerHTML || yearElement.textContent || new Date().getFullYear());
		} else {
			// Fallback to current date
			var now = new Date();
			month = now.getMonth() + 1;
			year = now.getFullYear();
		}
		
		// Get bookings via AJAX (synchronous to add to response before it's used)
		var bookingsAdded = false;
		$.ajax({
			url: tutorScheduling.ajaxurl,
			type: 'POST',
			async: false, // Make synchronous to add to response before it's used
			data: {
				action: 'tutor_scheduling_get_calendar_bookings',
				nonce: tutorScheduling.nonce,
				month: month - 1, // 0-based for JS (Tutor uses 0-based months)
				year: year
			},
			success: function(response) {
				if (response.success && response.data.events) {
					// Merge bookings into calendar data
					data.data.response = data.data.response.concat(response.data.events);
					
					// Update counts
					response.data.events.forEach(function(event) {
						if (event.meta_info && event.meta_info.is_expired) {
							data.data.overdue = (data.data.overdue || 0) + 1;
						} else {
							data.data.upcoming = (data.data.upcoming || 0) + 1;
						}
					});
					bookingsAdded = true;
				}
			}
		});
		
		return bookingsAdded;
	}
	
	// Handle date clicks in Tutor Calendar (for students to book)
	function handleDateClick() {
		// Wait for calendar to render (React component)
		var checkInterval = setInterval(function() {
			var calendarBody = document.querySelector('.tutor-calendar-body');
			if (calendarBody && calendarBody.children.length > 0) {
				clearInterval(checkInterval);
				
				// Listen for clicks on calendar days using event delegation
				// Tutor Calendar uses React, so we need to listen on the body
				$(document).on('click', '.tutor-calendar-date a, .tutor-calendar-date', function(e) {
					// Only for students
					if (tutorScheduling.userRole === 'tutor_instructor') {
						return;
					}
					
					e.preventDefault();
					e.stopPropagation();
					
					var $day = $(this).closest('.tutor-calendar-date');
					var dayNum = parseInt($day.find('a').text().trim() || $day.text().trim());
					
					if (isNaN(dayNum) || dayNum < 1) {
						return;
					}
					
					// Get current month and year from Tutor Calendar
					var monthElement = document.getElementById('tutor-c-calendar-month');
					var yearElement = document.getElementById('tutor-c-calendar-year');
					
					var month = 0;
					var year = new Date().getFullYear();
					
					if (monthElement) {
						// Try to get from data attribute first
						month = parseInt(monthElement.dataset.value || monthElement.getAttribute('data-value') || 0);
					}
					
					if (yearElement) {
						year = parseInt(yearElement.innerHTML || yearElement.textContent || year);
					}
					
					// Construct date (month is 0-based in JS)
					var date = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(dayNum).padStart(2, '0');
					
					// Check if date is in the past
					var today = new Date();
					today.setHours(0, 0, 0, 0);
					var selectedDate = new Date(date + 'T00:00:00');
					
					if (selectedDate >= today) {
						showBookingModal(date);
					}
				});
			}
		}, 500);
		
		// Stop checking after 10 seconds
		setTimeout(function() {
			clearInterval(checkInterval);
		}, 10000);
	}
	
	// Show booking modal when student clicks on a date
	function showBookingModal(date) {
		// Get available teachers for this date
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
					var modal = createBookingModal(date, response.data.teachers);
					$('body').append(modal);
					$('#tutor-booking-modal').fadeIn();
				} else {
					alert('No available teachers for this date.');
				}
			},
			error: function() {
				alert('Error loading available teachers.');
			}
		});
	}
	
	// Create booking modal HTML
	function createBookingModal(date, teachers) {
		var modalHtml = '<div id="tutor-booking-modal" class="tutor-modal-overlay">' +
			'<div class="tutor-modal-content" style="max-width: 600px;">' +
				'<span class="tutor-modal-close">&times;</span>' +
				'<h2>Book a Lesson</h2>' +
				'<div class="tutor-booking-form">' +
					'<div class="booking-form-row">' +
						'<label><strong>Date:</strong></label>' +
						'<span>' + formatDate(date) + '</span>' +
						'<input type="hidden" id="booking-date-input" value="' + date + '">' +
					'</div>' +
					'<div class="booking-form-row">' +
						'<label><strong>Select Teacher:</strong></label>' +
						'<select id="booking-teacher-select" required>' +
							'<option value="">Select a teacher</option>';
		
		teachers.forEach(function(teacher) {
			modalHtml += '<option value="' + teacher.id + '" data-slots=\'' + JSON.stringify(teacher.slots || []) + '\'';
			if (teacher.courses) {
				modalHtml += ' data-courses=\'' + JSON.stringify(teacher.courses) + '\'';
			}
			modalHtml += '>' + teacher.name;
			if (teacher.courses && teacher.courses.length > 0) {
				modalHtml += ' (' + teacher.courses.length + ' course' + (teacher.courses.length > 1 ? 's' : '') + ')';
			}
			modalHtml += '</option>';
		});
		
		modalHtml += '</select>' +
					'</div>' +
					'<div class="booking-form-row" id="course-select-row" style="display:none;">' +
						'<label><strong>Select Course:</strong></label>' +
						'<select id="booking-course-select" required>' +
							'<option value="">Select a course</option>' +
						'</select>' +
					'</div>' +
					'<div class="booking-form-row" id="time-select-row" style="display:none;">' +
						'<label><strong>Select Time:</strong></label>' +
						'<select id="booking-time-select" required>' +
							'<option value="">Select a time</option>' +
						'</select>' +
					'</div>' +
					'<div class="booking-form-row" id="subscription-select-row" style="display:none;">' +
						'<label><strong>Select Subscription:</strong></label>' +
						'<select id="booking-subscription-select" required>' +
							'<option value="">Loading...</option>' +
						'</select>' +
					'</div>' +
					'<div class="tutor-modal-actions">' +
						'<button type="button" class="tutor-btn tutor-btn-primary" id="submit-booking">Book Lesson</button>' +
						'<button type="button" class="tutor-btn tutor-btn-secondary tutor-modal-close">Cancel</button>' +
					'</div>' +
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
	
	// Initialize when document is ready
	$(document).ready(function() {
		// Wait for Tutor Calendar to be ready
		var checkCalendar = setInterval(function() {
			if ($('#tutor_calendar_wrapper').length && $('#tutor_calendar_wrapper').children().length > 0) {
				clearInterval(checkCalendar);
				handleDateClick();
			}
		}, 500);
		
		// Stop checking after 10 seconds
		setTimeout(function() {
			clearInterval(checkCalendar);
		}, 10000);
		
		// Handle teacher selection in booking modal
		$(document).on('change', '#booking-teacher-select', function() {
			var $select = $(this);
			var teacherId = $select.val();
			var $option = $select.find('option:selected');
			var slots = $option.data('slots') || [];
			var courses = $option.data('courses') || [];
			
			// Show/hide course select
			if (courses.length > 0) {
				var $courseSelect = $('#booking-course-select');
				$courseSelect.empty().append('<option value="">Select a course</option>');
				courses.forEach(function(course) {
					$courseSelect.append('<option value="' + course.id + '">' + course.title + '</option>');
				});
				$('#course-select-row').show();
			} else {
				$('#course-select-row').hide();
			}
			
			// Show time slots
			if (slots.length > 0) {
				var $timeSelect = $('#booking-time-select');
				$timeSelect.empty().append('<option value="">Select a time</option>');
				slots.forEach(function(slot) {
					var time = slot.substring(0, 5);
					$timeSelect.append('<option value="' + slot + '">' + time + '</option>');
				});
				$('#time-select-row').show();
			} else {
				$('#time-select-row').hide();
			}
			
			// Load subscriptions when course is selected
			if (courses.length === 0 && teacherId) {
				loadSubscriptions(teacherId, null);
			}
		});
		
		// Handle course selection
		$(document).on('change', '#booking-course-select', function() {
			var courseId = $(this).val();
			var teacherId = $('#booking-teacher-select').val();
			if (courseId && teacherId) {
				loadSubscriptions(teacherId, courseId);
			}
		});
		
		// Load subscriptions
		function loadSubscriptions(teacherId, courseId) {
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_get_subscription_details',
					nonce: tutorScheduling.nonce,
					student_id: tutorScheduling.currentUserId || 0
				},
				success: function(response) {
					if (response.success && response.data.details) {
						var $select = $('#booking-subscription-select');
						$select.empty();
						
						var hasSubscriptions = false;
						if (Array.isArray(response.data.details)) {
							response.data.details.forEach(function(detail) {
								if (detail && detail.course) {
									if (!courseId || detail.course.ID == courseId) {
										$select.append('<option value="' + detail.subscription_id + '">' + 
											detail.course.post_title + ' (' + detail.remaining_lessons + ' lessons remaining)' +
										'</option>');
										hasSubscriptions = true;
									}
								}
							});
						}
						
						if (hasSubscriptions) {
							$('#subscription-select-row').show();
						} else {
							$('#subscription-select-row').hide();
							alert('You need to purchase a subscription to book lessons.');
						}
					}
				}
			});
		}
		
		// Handle booking submission
		$(document).on('click', '#submit-booking', function() {
			var date = $('#booking-date-input').val();
			var teacherId = $('#booking-teacher-select').val();
			var courseId = $('#booking-course-select').val();
			var time = $('#booking-time-select').val();
			var subscriptionId = $('#booking-subscription-select').val();
			
			if (!teacherId || !time) {
				alert('Please select a teacher and time.');
				return;
			}
			
			// If course select is hidden, get course from teacher
			if (!courseId) {
				var $teacherOption = $('#booking-teacher-select option:selected');
				var courses = $teacherOption.data('courses') || [];
				if (courses.length === 1) {
					courseId = courses[0].id;
				} else {
					alert('Please select a course.');
					return;
				}
			}
			
			if (!subscriptionId) {
				alert('Please select a subscription.');
				return;
			}
			
			// Submit booking
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_book_from_calendar',
					nonce: tutorScheduling.nonce,
					teacher_id: teacherId,
					course_id: courseId,
					booking_date: date,
					booking_time: time,
					subscription_id: subscriptionId
				},
				success: function(response) {
					if (response.success) {
						alert(response.data.message || 'Booking request submitted! Waiting for teacher approval.');
						$('#tutor-booking-modal').fadeOut(function() {
							$(this).remove();
						});
						// Reload calendar
						setTimeout(function() {
							window.location.reload();
						}, 1000);
					} else {
						alert(response.data.message || 'Failed to create booking.');
					}
				},
				error: function() {
					alert('Error creating booking.');
				}
			});
		});
		
		// Close modal
		$(document).on('click', '.tutor-modal-close, .tutor-modal-overlay', function(e) {
			if (e.target === this || $(e.target).hasClass('tutor-modal-close')) {
				$('#tutor-booking-modal').fadeOut(function() {
					$(this).remove();
				});
			}
		});
		
		// Handle booking details click (for viewing existing bookings)
		$(document).on('click', '.tutor-scheduling-booking-event, .booking-details-link', function(e) {
			e.preventDefault();
			var bookingId = $(this).closest('.tutor-scheduling-booking-event').data('booking-id') || 
			                $(this).data('booking-id');
			if (bookingId) {
				showBookingDetailsModal(bookingId);
			}
		});
	});
	
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
					var modal = createBookingDetailsModal(data);
					$('body').append(modal);
					$('#tutor-booking-details-modal').fadeIn();
				} else {
					alert(response.data.message || 'Failed to load booking details');
				}
			},
			error: function() {
				alert('Error loading booking details');
			}
		});
	}
	
	// Create booking details modal HTML
	function createBookingDetailsModal(data) {
		var booking = data.booking;
		var student = data.student;
		var teacher = data.teacher;
		var course = data.course;
		var lesson = data.lesson;
		
		var modalHtml = '<div id="tutor-booking-details-modal" class="tutor-modal-overlay">' +
			'<div class="tutor-modal-content">' +
				'<span class="tutor-modal-close">&times;</span>' +
				'<h2>' + (booking.status === 'scheduled' ? 'Scheduled Lesson' : 'Lesson Details') + '</h2>' +
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
	
	// Format time
	function formatTime(timeStr) {
		if (!timeStr) return '';
		var time = timeStr.substring(0, 5);
		return time;
	}
	
})(jQuery);
