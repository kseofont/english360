/**
 * Calendar Booking Integration
 * Handles date clicks in calendar and booking modal
 */

(function($) {
	'use strict';
	
	// Show booking modal when student clicks on a date
	function showBookingModal(date) {
		console.log('showBookingModal called with date:', date);
		
		// Check if tutorScheduling is defined
		if (typeof tutorScheduling === 'undefined') {
			console.error('tutorScheduling is not defined!');
			alert('Error: Booking system not initialized. Please refresh the page.');
			return;
		}
		
		// Get student's enrolled courses
		var studentId = tutorScheduling.currentUserId || 0;
		
		console.log('Fetching available teachers for date:', date);
		
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
				console.log('Available teachers response:', response);
				if (response.success && response.data && response.data.teachers && response.data.teachers.length > 0) {
					var modal = createBookingModal(date, response.data.teachers);
					$('body').append(modal);
					$('#tutor-booking-modal').fadeIn();
					console.log('Booking modal opened');
					
					// Auto-load subscriptions if teacher has only one course
					setTimeout(function() {
						var $teacherSelect = $('#booking-teacher-select');
						if ($teacherSelect.length) {
							var $firstTeacherOption = $teacherSelect.find('option').eq(1); // Skip "Select a teacher"
							if ($firstTeacherOption.length) {
								var courses = $firstTeacherOption.data('courses') || [];
								if (courses.length === 1) {
									// Auto-select course and load subscriptions
									$('#booking-course-select').val(courses[0].id).trigger('change');
								} else if (courses.length === 0) {
									// Teacher has no courses listed, try to load subscriptions anyway
									var teacherId = $firstTeacherOption.val();
									if (teacherId) {
										loadSubscriptions(teacherId, null);
									}
								}
							}
						}
					}, 200);
				} else {
					alert('No available teachers for this date.');
				}
			},
			error: function(xhr, status, error) {
				console.error('Error loading available teachers:', error, xhr);
				alert('Error loading available teachers. Please check console for details.');
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
			modalHtml += '<option value="' + teacher.id + '" data-slots=\'' + JSON.stringify(teacher.slots) + '\'';
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
	
	// Initialize
	$(document).ready(function() {
		console.log('Calendar booking script loaded');
		console.log('tutorScheduling:', typeof tutorScheduling !== 'undefined' ? tutorScheduling : 'NOT DEFINED');
		
		// Initialize booking handlers (teacher selection, course selection, etc.)
		initializeBookingHandlers();
		
		// Only allow booking for students (not teachers)
		if (typeof tutorScheduling !== 'undefined' && tutorScheduling.userRole === 'tutor_instructor') {
			console.log('User is teacher, booking disabled');
			return; // Teachers can't book, they approve
		}
		
		console.log('User is student, booking enabled');
		
		// Wait for Tutor Calendar React component to be fully loaded
		var calendarCheckInterval = setInterval(function() {
			var $calendarWrapper = $('#tutor_calendar_wrapper');
			if ($calendarWrapper.length) {
				// Check if calendar body exists (React component rendered)
				// Try multiple selectors to find calendar structure
				var $calendarBody = $calendarWrapper.find('.tutor-calendar-body');
				if ($calendarBody.length === 0) {
					$calendarBody = $calendarWrapper.find('.tutor-custom-calendar');
				}
				if ($calendarBody.length === 0) {
					$calendarBody = $calendarWrapper.find('[class*="calendar"]');
				}
				
				// Check if calendar has any day elements
				var hasDays = $calendarBody.find('div').length > 0;
				
				if ($calendarBody.length > 0 && hasDays) {
					console.log('Calendar found, setting up handlers');
					clearInterval(calendarCheckInterval);
					setupCalendarClickHandlers();
				} else {
					console.log('Waiting for calendar to load...', {
						wrapper: $calendarWrapper.length,
						body: $calendarBody.length,
						days: hasDays
					});
				}
			} else {
				console.log('Calendar wrapper not found');
			}
		}, 500);
		
		// Stop checking after 15 seconds
		setTimeout(function() {
			clearInterval(calendarCheckInterval);
			console.log('Calendar check timeout reached');
		}, 15000);
	});
	
	// Handle date click (extracted to avoid code duplication)
	function handleDateClick(dayNumber, e) {
		// Get current month and year from calendar
		var monthText = $('#tutor-c-calendar-month').text().trim();
		var yearText = $('#tutor-c-calendar-year').text().trim();
		
		// Try alternative selectors for month/year
		if (!monthText) {
			monthText = $('.tutor-calendar-dropdown-current-month').text().trim();
		}
		if (!yearText) {
			yearText = $('.tutor-calendar-dropdown-current-year').text().trim();
		}
		
		if (!monthText || !yearText) {
			console.log('Could not get month/year from calendar. Month:', monthText, 'Year:', yearText);
			return;
		}
		
		console.log('Month:', monthText, 'Year:', yearText, 'Day:', dayNumber);
		
		// Parse month name to number (0-based for JS Date)
		var months = ['January', 'February', 'March', 'April', 'May', 'June', 
		              'July', 'August', 'September', 'October', 'November', 'December'];
		var month = months.indexOf(monthText);
		
		// Try abbreviated names if full name didn't work
		if (month === -1) {
			var monthAbbr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
			                 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			for (var i = 0; i < monthAbbr.length; i++) {
				if (monthText.indexOf(monthAbbr[i]) === 0) {
					month = i;
					break;
				}
			}
		}
		
		var year = parseInt(yearText);
		
		if (month >= 0 && year && !isNaN(year)) {
			// Month is 0-based in JS, but we need 1-based for date string
			var date = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(dayNumber).padStart(2, '0');
			
			console.log('Selected date:', date);
			
			// Check if date is in the past
			var today = new Date();
			today.setHours(0, 0, 0, 0);
			var selectedDate = new Date(date + 'T00:00:00');
			
			if (selectedDate >= today) {
				if (e) {
					e.preventDefault();
					e.stopPropagation();
				}
				console.log('Opening booking modal for date:', date);
				showBookingModal(date);
			} else {
				console.log('Date is in the past, cannot book');
			}
		} else {
			console.log('Invalid month or year. Month:', month, 'Year:', year);
		}
	}
	
	// Setup click handlers for Tutor Calendar
	function setupCalendarClickHandlers() {
		console.log('Setting up calendar click handlers...');
		
		// Approach 1: Direct click on calendar wrapper (most reliable for React components)
		$('#tutor_calendar_wrapper').on('click', function(e) {
			console.log('Click detected in calendar wrapper', e.target);
			
			var $target = $(e.target);
			
			// Check if clicking on a link that's part of an event (not a date)
			if ($target.closest('.tutor-event-wrapper').length) {
				console.log('Skipping click - clicked on event');
				return;
			}
			
			// If clicking on a link, check if it's just a date number
			var isDateLink = false;
			if ($target.is('a')) {
				var linkText = $target.text().trim();
				// If link contains only a number 1-31, it's likely a date
				var dateMatch = linkText.match(/^\d+$/);
				if (dateMatch) {
					var num = parseInt(dateMatch[0]);
					if (num >= 1 && num <= 31) {
						isDateLink = true;
						console.log('Date link detected:', num);
					}
				}
			}
			
			// Skip if clicking on buttons, inputs, selects, or event links
			if (!$target.is('a') && !isDateLink && 
			    ($target.is('button, input, select') || 
			     $target.closest('button, input, select').length)) {
				console.log('Skipping click - clicked on interactive element');
				return;
			}
			
			// Try to find the day number from the clicked element and its parents
			var dayNumber = null;
			var $checkElement = $target;
			
			// If it's a date link, use it directly
			if (isDateLink) {
				var linkText = $checkElement.text().trim();
				dayNumber = parseInt(linkText);
				console.log('Using day number from date link:', dayNumber);
			} else {
				// Check up to 3 levels up
				for (var i = 0; i < 3 && !dayNumber; i++) {
					var dayText = $checkElement.text().trim();
					// Look for a number that's 1-31
					var dayMatch = dayText.match(/\b([1-9]|[12][0-9]|3[01])\b/);
					
					if (dayMatch) {
						var num = parseInt(dayMatch[1]);
						// Make sure it's not part of a year (4 digits) or time
						if (num >= 1 && num <= 31 && dayText.length < 10) {
							dayNumber = num;
							console.log('Found day number:', dayNumber, 'from element:', $checkElement[0]);
							break;
						}
					}
					
					$checkElement = $checkElement.parent();
					if (!$checkElement.length || $checkElement.is('#tutor_calendar_wrapper')) {
						break;
					}
				}
			}
			
			if (!dayNumber) {
				console.log('No valid day number found in clicked element');
				return;
			}
			
			// Prevent default link behavior for date links
			if (isDateLink) {
				e.preventDefault();
				e.stopPropagation();
			}
			
			console.log('Calendar day clicked (approach 1):', dayNumber);
			handleDateClick(dayNumber, e);
		});
		
		// Approach 2: Event delegation on specific selectors (fallback)
		// This catches clicks on calendar day cells directly
		var selectors = [
			'#tutor_calendar_wrapper .tutor-calendar-body > div',
			'#tutor_calendar_wrapper .tutor-calendar-body div',
			'#tutor_calendar_wrapper .tutor-custom-calendar div',
			'#tutor_calendar_wrapper div[class*="calendar"]'
		];
		
		$(document).on('click', selectors.join(', '), function(e) {
			// Don't trigger if clicking on an event, link, or space
			if ($(e.target).closest('.tutor-event-wrapper').length || 
			    $(e.target).closest('a').length ||
			    $(e.target).is('a, button, input, select') ||
			    $(this).hasClass('space') || 
			    $(this).hasClass('tutor-event-wrapper')) {
				return;
			}
			
			var $day = $(this);
			var dayText = $day.text().trim();
			
			// Extract just the number from the text (remove any extra characters)
			var dayMatch = dayText.match(/\b([1-9]|[12][0-9]|3[01])\b/);
			if (!dayMatch) {
				return; // No valid day number found
			}
			
			var dayNumber = parseInt(dayMatch[1]);
			
			if (isNaN(dayNumber) || dayNumber < 1 || dayNumber > 31) {
				return; // Not a valid day
			}
			
			console.log('Calendar day clicked (approach 2):', dayNumber);
			handleDateClick(dayNumber, e);
		});
	}
	
	// Handle date click (extracted to avoid code duplication)
	function handleDateClick(dayNumber, e) {
		// Get current month and year from calendar
		var monthText = $('#tutor-c-calendar-month').text().trim();
		var yearText = $('#tutor-c-calendar-year').text().trim();
		
		// Try alternative selectors for month/year
		if (!monthText) {
			monthText = $('.tutor-calendar-dropdown-current-month').text().trim();
		}
		if (!yearText) {
			yearText = $('.tutor-calendar-dropdown-current-year').text().trim();
		}
		
		if (!monthText || !yearText) {
			console.log('Could not get month/year from calendar. Month:', monthText, 'Year:', yearText);
			return;
		}
		
		console.log('Month:', monthText, 'Year:', yearText, 'Day:', dayNumber);
		
		// Parse month name to number (0-based for JS Date)
		var months = ['January', 'February', 'March', 'April', 'May', 'June', 
		              'July', 'August', 'September', 'October', 'November', 'December'];
		var month = months.indexOf(monthText);
		
		// Try abbreviated names if full name didn't work
		if (month === -1) {
			var monthAbbr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
			                 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			for (var i = 0; i < monthAbbr.length; i++) {
				if (monthText.indexOf(monthAbbr[i]) === 0) {
					month = i;
					break;
				}
			}
		}
		
		var year = parseInt(yearText);
		
		if (month >= 0 && year && !isNaN(year)) {
			// Month is 0-based in JS, but we need 1-based for date string
			var date = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(dayNumber).padStart(2, '0');
			
			console.log('Selected date:', date);
			
			// Check if date is in the past
			var today = new Date();
			today.setHours(0, 0, 0, 0);
			var selectedDate = new Date(date + 'T00:00:00');
			
			if (selectedDate >= today) {
				if (e) {
					e.preventDefault();
					e.stopPropagation();
				}
				console.log('Opening booking modal for date:', date);
				showBookingModal(date);
			} else {
				console.log('Date is in the past, cannot book');
			}
		} else {
			console.log('Invalid month or year. Month:', month, 'Year:', year);
		}
		
		// Also handle clicks on booking events to show details
		// Tutor Calendar renders events with post_type in meta_info
		$(document).on('click', '#tutor_calendar_wrapper .tutor-event-wrapper', function(e) {
			// Check if this is a booking event by looking at the link or title
			var $event = $(this);
			var $link = $event.find('a');
			var href = $link.attr('href');
			
			// Try to extract booking ID from various places
			var bookingId = $event.data('booking-id');
			
			// If no data attribute, try to get from the event title or meta
			if (!bookingId) {
				var eventTitle = $link.find('span').last().text();
				// Booking events might have "Lesson with..." or similar
				if (eventTitle && (eventTitle.toLowerCase().indexOf('lesson') !== -1 || 
				    eventTitle.toLowerCase().indexOf('booking') !== -1)) {
					// We'll need to fetch booking by date/time instead
					// For now, just prevent default and show a message
					e.preventDefault();
					e.stopPropagation();
					// Try to get date from parent listing
					var $listing = $event.closest('.tutor-event-listing');
					if ($listing.length) {
						var dateText = $listing.find('.icon-wrapper span').text();
						console.log('Booking event clicked, date:', dateText);
						// Could implement fetching booking by date here
					}
				}
			} else {
				e.preventDefault();
				e.stopPropagation();
				showBookingDetailsModal(bookingId);
			}
		});
	}
	
	// Show booking details modal (for viewing existing bookings)
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
	
	// Format time
	function formatTime(timeStr) {
		if (!timeStr) return '';
		// Time is in HH:MM:SS format, extract HH:MM
		var parts = timeStr.split(':');
		if (parts.length >= 2) {
			var hours = parseInt(parts[0]);
			var minutes = parts[1];
			var ampm = hours >= 12 ? 'PM' : 'AM';
			hours = hours % 12;
			hours = hours ? hours : 12; // the hour '0' should be '12'
			return hours + ':' + minutes + ' ' + ampm;
		}
		return timeStr;
	}
	
	// Initialize event handlers
	function initializeBookingHandlers() {
		// Handle teacher selection
		$(document).on('change', '#booking-teacher-select', function() {
			var $select = $(this);
			var teacherId = $select.val();
			var $option = $select.find('option:selected');
			var slots = $option.data('slots') || [];
			var courses = $option.data('courses') || [];
			
			console.log('Teacher selected:', teacherId, 'Courses:', courses, 'Slots:', slots);
			
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
			
			// Reset subscription select
			$('#subscription-select-row').hide();
			$('#booking-subscription-select').empty();
		});
		
		// Handle course selection
		$(document).on('change', '#booking-course-select', function() {
			var courseId = $(this).val();
			var teacherId = $('#booking-teacher-select').val();
			console.log('Course selected:', courseId);
			if (courseId && teacherId) {
				loadSubscriptions(teacherId, courseId);
			} else if (courseId) {
				// Load subscriptions even without teacher (for course filtering)
				loadSubscriptions(null, courseId);
			}
		});
		
		// Load subscriptions
		function loadSubscriptions(teacherId, courseId) {
			console.log('Loading subscriptions for course:', courseId);
			// Get student's subscriptions for this course/teacher
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_get_subscription_details',
					nonce: tutorScheduling.nonce,
					student_id: tutorScheduling.currentUserId || 0
				},
				success: function(response) {
					console.log('Subscriptions response:', response);
					if (response.success && response.data && response.data.details) {
						var $select = $('#booking-subscription-select');
						$select.empty();
						
						var hasSubscriptions = false;
						if (Array.isArray(response.data.details)) {
							response.data.details.forEach(function(detail) {
								console.log('Subscription detail:', detail);
								if (detail) {
									// Get subscription data (can be in different formats)
									var subscription = detail.subscription || detail;
									var status = detail.status || (subscription ? subscription.status : null);
									var remaining = detail.remaining_lessons || (subscription ? subscription.remaining_lessons : 0);
									var subscriptionId = detail.subscription_id || (subscription ? subscription.subscription_id : null);
									var courseIdInDetail = detail.course_id || (detail.course ? detail.course.ID : null) || (subscription ? subscription.course_id : null);
									
									// Check if subscription is active and has remaining lessons
									if (status === 'active' && remaining > 0 && subscriptionId) {
										// Filter by course if specified
										if (!courseId || courseIdInDetail == courseId) {
											var courseTitle = detail.course ? detail.course.post_title : (courseIdInDetail ? 'Course #' + courseIdInDetail : 'Course');
											$select.append('<option value="' + subscriptionId + '">' + 
												courseTitle + ' (' + remaining + ' lessons remaining)' +
											'</option>');
											hasSubscriptions = true;
											console.log('Added subscription:', subscriptionId, 'for course:', courseIdInDetail);
										} else {
											console.log('Skipping subscription - course mismatch:', courseIdInDetail, 'vs', courseId);
										}
									} else {
										console.log('Skipping subscription - inactive or no lessons:', {status: status, remaining: remaining});
									}
								}
							});
						}
						
						if (hasSubscriptions) {
							$('#subscription-select-row').show();
							console.log('Subscriptions loaded:', $select.find('option').length);
						} else {
							$('#subscription-select-row').hide();
							console.log('No subscriptions found');
							// Don't show alert immediately, let user see the form first
						}
					} else {
						console.log('No subscription details in response');
						$('#subscription-select-row').hide();
					}
				},
				error: function(xhr, status, error) {
					console.error('Error loading subscriptions:', error, xhr);
					$('#subscription-select-row').hide();
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
			
			console.log('Booking submission:', {
				date: date,
				teacherId: teacherId,
				courseId: courseId,
				time: time,
				subscriptionId: subscriptionId
			});
			
			if (!teacherId || !time) {
				alert('Please select a teacher and time.');
				return;
			}
			
			// If course select is hidden, we need to get course from teacher
			if (!courseId) {
				var $teacherOption = $('#booking-teacher-select option:selected');
				var courses = $teacherOption.data('courses') || [];
				if (courses.length === 1) {
					courseId = courses[0].id;
					console.log('Auto-selected course:', courseId);
				} else {
					alert('Please select a course.');
					return;
				}
			}
			
			if (!subscriptionId || subscriptionId === '0' || subscriptionId === '') {
				// Try to find subscription automatically if not selected
				var $subscriptionSelect = $('#booking-subscription-select');
				if ($subscriptionSelect.length && $subscriptionSelect.find('option').length === 1) {
					// Only one option, use it
					subscriptionId = $subscriptionSelect.find('option').first().val();
					console.log('Auto-selected subscription:', subscriptionId);
				} else {
					alert('Please select a subscription. If you don\'t have one, please purchase a subscription first.');
					return;
				}
			}
			
			// Disable button to prevent double submission
			var $button = $(this);
			$button.prop('disabled', true).text('Booking...');
			
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
					console.log('Booking response:', response);
					console.log('Response data:', response.data);
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
						var errorMsg = 'Failed to create booking.';
						if (response.data) {
							if (response.data.message) {
								errorMsg = response.data.message;
							} else {
								errorMsg = JSON.stringify(response.data);
							}
						}
						console.error('Booking failed:', response);
						console.error('Error message:', errorMsg);
						alert(errorMsg);
						$button.prop('disabled', false).text('Book Lesson');
					}
				},
				error: function(xhr, status, error) {
					console.error('AJAX error:', status, error, xhr);
					console.error('Response:', xhr.responseText);
					alert('Error creating booking. Please check console for details.');
					$button.prop('disabled', false).text('Book Lesson');
				}
			});
		});
		
		// Handle approve/reject buttons for teachers
		$(document).on('click', '.approve-booking', function() {
			var $button = $(this);
			var bookingId = $button.data('booking-id');
			
			if (!confirm('Approve this booking?')) {
				return;
			}
			
			$button.prop('disabled', true).text('Approving...');
			
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_approve_booking',
					nonce: tutorScheduling.nonce,
					booking_id: bookingId
				},
				success: function(response) {
					if (response.success) {
						alert(response.data.message || 'Booking approved!');
						window.location.reload();
					} else {
						alert(response.data.message || 'Failed to approve booking.');
						$button.prop('disabled', false).text('Approve');
					}
				},
				error: function() {
					alert('Error approving booking.');
					$button.prop('disabled', false).text('Approve');
				}
			});
		});
		
		$(document).on('click', '.reject-booking', function() {
			var $button = $(this);
			var bookingId = $button.data('booking-id');
			
			if (!confirm('Reject this booking?')) {
				return;
			}
			
			$button.prop('disabled', true).text('Rejecting...');
			
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_reject_booking',
					nonce: tutorScheduling.nonce,
					booking_id: bookingId
				},
				success: function(response) {
					if (response.success) {
						alert(response.data.message || 'Booking rejected.');
						window.location.reload();
					} else {
						alert(response.data.message || 'Failed to reject booking.');
						$button.prop('disabled', false).text('Reject');
					}
				},
				error: function() {
					alert('Error rejecting booking.');
					$button.prop('disabled', false).text('Reject');
				}
			});
		});
	}
	
})(jQuery);

