<!DOCTYPE html>
<html>
<head>
  {{-- HEADER --}}
  @include('partials.adminHeader')
  <link rel="stylesheet" href="{{ asset('css/styles.css')}}">

{{-- SIDE NAVIGATION BAR --}}
<div id="sidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="{{ route ('admin/home')}}">Dashboard</a>
    <a href="{{ route ('appointments.index')}}">Appointments</a>
    <a href="#">Patient's Record</a>
    <a href="#">Reports</a>
    <a href="{{ route ('admin/maintenance')}}">Maintenance</a>
    <a href="{{ route ('admin/inventory')}}">Inventory</a>
    <a href="#">Help</a>
    <a href="#">About</a>
    <a href="{{ route ('logout') }}">Logout</a>
</div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.css" rel="stylesheet">
    <style>
      /* Styles for the modal */
      .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
      }

      .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
      }

      .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
      }

      .close:hover,
      .close:focus {
        color: #000;
        text-decoration: none;
      }

      /* Styles for the button */
      .create-button {
        margin: 10px;
      }

      /* Styles for confirmation modal */
      #confirmation-modal .modal-content {
        width: 40%;
        text-align: center;
      }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay'
          },
          events: <?php echo json_encode($appointments->map(function($appointment) {
              return [
                $last_name = $appointment->patient->last_name,
                $first_name = $appointment->patient->first_name,
                $middle_name = $appointment->patient->middle_name,
                $name = $last_name.', '.$first_name.' '.$middle_name,
                  'title' => $appointment->type_of_appointment,
                  'start' => $appointment->start_datetime,
                  'end' => $appointment->end_datetime,
                  'description' => $name,
                  'id' => $appointment->id
              ];
          })); ?>,
          eventClick: function(info) {
            const appointment = info.event;
            const modal = document.getElementById('myModal');
            const modalContent = document.getElementById('modal-content');
            modal.style.display = "block";
            modalContent.innerHTML = `
              <span class="close" onclick="closeModal('myModal')">&times;</span>
              <h2>${appointment.title}</h2>
              <p><strong>Patient:</strong> ${appointment.extendedProps.description}</p>
              <p><strong>Start Time:</strong> ${appointment.start.toLocaleString()}</p>
              <button class="cancel-appointment-button" data-id="${appointment.id}">Cancel</button>
              <button class="complete-appointment-button" data-id="${appointment.id}">Complete</button>
            `;
          }
        });
        calendar.render();

        document.addEventListener('click', function(event) {
          if (event.target.classList.contains('cancel-appointment-button')) {
            const appointmentId = event.target.getAttribute('data-id');
            openConfirmationModal(appointmentId);
          } else if (event.target.classList.contains('complete-appointment-button')) {
            const appointmentId = event.target.getAttribute('data-id');
            completeAppointment(appointmentId);
          } else if (event.target.classList.contains('close')) {
            const modalId = event.target.closest('.modal').id;
            closeModal(modalId);
          }
        });

        function closeModal(modalId) {
          const modal = document.getElementById(modalId);
          modal.style.display = "none";
        }

        window.cancelAppointment = function(appointmentId) {
          fetch(`/appointments/${appointmentId}/cancel`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const event = calendar.getEventById(appointmentId);
              event.remove();
              // Display modal for successful cancellation
              const successModal = document.getElementById('success-modal');
              successModal.style.display = "block";
            } else {
              alert('Failed to cancel appointment: ' + data.message);
            }
            closeModal('confirmation-modal');
            closeModal('myModal');
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again: ' + error.message);
            closeModal('confirmation-modal');
            closeModal('myModal');
          });
        }

        window.completeAppointment = function(appointmentId) {
          // Logic to complete appointment goes here
          alert('Appointment completed!');
          closeModal('myModal');
        }

        window.openConfirmationModal = function(appointmentId) {
          const confirmationModal = document.getElementById('confirmation-modal');
          confirmationModal.style.display = "block";
          document.getElementById('confirm-cancel-button').onclick = function() {
            cancelAppointment(appointmentId);
          };
        }
      });
    </script>
</head>
<body>
    <div>
        <button class="create-button" onclick="location.href='{{ route('appointments.create') }}'">Create Appointment</button>
    </div>

    <div id='calendar'></div>

    <!-- Appointment Details Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="modal-content">
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('confirmation-modal')">&times;</span>
            <h2>Confirm Cancellation</h2>
            <p>Are you sure you want to cancel this appointment?</p>
            <button id="confirm-cancel-button">Yes, Cancel</button>
            <button class="close-modal-button">No, Go Back</button>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal('success-modal')">&times;</span>
        <h2>Appointment Canceled Successfully</h2>
        <p>The appointment has been successfully canceled.</p>
        <!-- Add any additional content or styling as needed -->
      </div>
    </div>
    <!-- NAV BAR SCRIPT -->
    <script>
        // Get current date and time
        var now = new Date();
        year = now.getFullYear();
        const monthNames = [
            "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December"
        ];
        month = monthNames[now.getMonth() + 1];
        date = now.getDate();
        const dayNames = [
            "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", 
        ];
        day = dayNames[now.getDay()];
        hours = now.getHours();
        minutes = now.getMinutes();
        seconds = now.getSeconds();
        
        document.getElementById("date").innerHTML = month + " " + date + ", " + year;
        document.getElementById("day_and_time").innerHTML = day + ", " + hours + ":" + minutes + ":" + seconds;

        // Opening the navbar
        function openNav() {
            document.getElementById("sidenav").style.width = "250px";
        }

        // Closing the navbar
        function closeNav() {
            document.getElementById("sidenav").style.width = "0";
        }
      </script>
</body>
</html>
