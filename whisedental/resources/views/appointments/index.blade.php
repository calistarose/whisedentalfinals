<!DOCTYPE html>
<html>
<head>
  {{-- HEADER --}}
  @include('partials.adminHeader')
  <link rel="stylesheet" href="{{ asset('css/styles.css')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}">

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
              'title' => $appointment->type_of_appointment . ' - ' . ucfirst($appointment->status),
              'start' => $appointment->start_datetime,
              'end' => $appointment->end_datetime,
              'description' => $appointment->patient->last_name . ', ' . $appointment->patient->first_name . ' ' . $appointment->patient->middle_name,
              'status' => $appointment->status,
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
            <p><strong>Status:</strong> ${appointment.extendedProps.status}</p>
            <button class="cancel-appointment-button" data-id="${appointment.id}">Cancel</button>
            <button class="complete-appointment-button" data-id="${appointment.id}">Complete</button>
          `;
        }
      });
      calendar.render();

      document.addEventListener('click', function(event) {
        if (event.target.classList.contains('cancel-appointment-button')) {
          const appointmentId = event.target.getAttribute('data-id');
          updateAppointmentStatus(appointmentId, 'cancelled');
        } else if (event.target.classList.contains('complete-appointment-button')) {
          const appointmentId = event.target.getAttribute('data-id');
          updateAppointmentStatus(appointmentId, 'complete');
        } else if (event.target.classList.contains('close')) {
          const modalId = event.target.closest('.modal').id;
          closeModal(modalId);
        }
      });

      function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = "none";
      }

      function updateAppointmentStatus(appointmentId, status) {
        fetch(`/appointments/${appointmentId}/status`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ status: status })
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            const event = calendar.getEventById(appointmentId);
            event.remove();
            alert(`Appointment ${status} successfully!`);
          } else {
            alert('Failed to update appointment: ' + data.message);
          }
          closeModal('myModal');
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again: ' + error.message);
          closeModal('myModal');
        });
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
