<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents Management - Barangay Cantil-E</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="res.css">
    <link rel="stylesheet" href="searchbar.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('secretary.components.sidebar')

        <!-- Main Content -->
        <div class="main-content flex-grow-1">


            <div class="container-fluid py-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Secretary Dashboard</h2>
                    <div class="search-container">
                        <div class="search-bar">
                            <input type="text" placeholder="Search..." />
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards Row -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Total Residents</h5>
                                <h3>1,234</h3>
                                <i class="bi bi-people float-end fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Active Cases</h5>
                                <h3>42</h3>
                                <i class="bi bi-file-text float-end fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5>Pending Documents</h5>
                                <h3>15</h3>
                                <i class="bi bi-file-earmark-text float-end fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>Today's Appointments</h5>
                                <h3>8</h3>
                                <i class="bi bi-calendar-check float-end fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities and Tasks -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Activities</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        New resident registration
                                        <span class="badge bg-primary">Just now</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Document request processed
                                        <span class="badge bg-primary">2h ago</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Complaint resolved
                                        <span class="badge bg-primary">3h ago</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Pending Tasks</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="task1">
                                            <label class="form-check-label" for="task1">Review clearance
                                                requests</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="task2">
                                            <label class="form-check-label" for="task2">Update resident
                                                records</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="task3">
                                            <label class="form-check-label" for="task3">Prepare monthly
                                                report</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- New Resident Modal -->
    <div class="modal fade" id="newResidentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Resident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="newResidentForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                                <div class="invalid-feedback">Please enter a first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                                <div class="invalid-feedback">Please enter a last name.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" required>
                                <div class="invalid-feedback">Please select a date of birth.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Civil Status</label>
                                <select class="form-select" id="civilStatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                                <div class="invalid-feedback">Please select a civil status.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="2" required></textarea>
                            <div class="invalid-feedback">Please enter an address.</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber" pattern="[0-9]{11}"
                                    required>
                                <div class="invalid-feedback">Please enter a valid 11-digit contact number.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email">
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="registerResidentBtn">Register
                        Resident</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Resident Modal -->
    <div class="modal fade" id="viewResidentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resident Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Resident Information -->
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="resident-photo mb-2">
                                <img src="logo.png" class="img-thumbnail square-box" alt="Resident Photo">
                            </div>
                            <span class="badge bg-success resident-status">Active</span>
                        </div>
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <p class="resident-name"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Resident ID</label>
                                    <p class="resident-id"></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Date of Birth</label>
                                    <p class="resident-dob"></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Age</label>
                                    <p class="resident-age"></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Gender</label>
                                    <p class="resident-gender"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Civil Status</label>
                                    <p class="resident-civil-status"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Contact Number</label>
                                    <p class="resident-contact"></p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Address</label>
                                    <p class="resident-address"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email</label>
                                    <p class="resident-email"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Registration Date</label>
                                    <p class="resident-reg-date"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Tabs -->
                    <ul class="nav nav-tabs mt-4" id="residentTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#documents">Documents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#complaints">Complaints</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#activities">Activities</a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 border border-top-0">
                        <div class="tab-pane fade show active" id="documents">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Date Issued</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="documentsList">
                                        <!-- Populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="complaints">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="complaintsList">
                                        <!-- Populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="activities">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Activity</th>
                                            <th>Participation</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="activitiesList">
                                        <!-- Populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printResidentDetails()">Print
                        Details</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap components
            const newResidentModal = new bootstrap.Modal(document.getElementById('newResidentModal'));
            const form = document.getElementById('newResidentForm');
            const registerBtn = document.getElementById('registerResidentBtn');

            // Search functionality
            const searchInput = document.querySelector('.search-bar input');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.table tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Form validation and submission
            registerBtn.addEventListener('click', function() {
                form.classList.remove('was-validated');

                if (form.checkValidity()) {
                    const formData = {
                        firstName: document.getElementById('firstName').value,
                        lastName: document.getElementById('lastName').value,
                        dateOfBirth: document.getElementById('dateOfBirth').value,
                        gender: document.getElementById('gender').value,
                        civilStatus: document.getElementById('civilStatus').value,
                        address: document.getElementById('address').value,
                        contactNumber: document.getElementById('contactNumber').value,
                        email: document.getElementById('email').value || null
                    };

                    // Here you would typically send the data to a server
                    console.log('Resident Data:', formData);

                    // Show success message and reset form
                    alert('Resident registered successfully!');
                    newResidentModal.hide();
                    form.reset();

                    // Remove validation classes
                    form.querySelectorAll('.is-valid, .is-invalid').forEach(element => {
                        element.classList.remove('is-valid', 'is-invalid');
                    });
                } else {
                    form.classList.add('was-validated');
                }
            });

            // Real-time form validation
            form.querySelectorAll('[required]').forEach(field => {
                field.addEventListener('input', function() {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                });
            });
        });

        // View resident details
        function viewResident(residentId) {
            // Fetch resident data (mock data for demonstration)
            const residentData = {
                id: residentId,
                name: 'Juan Dela Cruz',
                dob: 'January 15, 1978',
                age: '45',
                gender: 'Male',
                civilStatus: 'Married',
                contact: '0912-345-6789',
                address: 'Block 1, Lot 5, Cantil-E',
                email: 'juan.delacruz@email.com',
                regDate: 'March 15, 2023',
                documents: [{
                        type: 'Barangay Clearance',
                        date: '2023-12-15',
                        status: 'Issued'
                    },
                    {
                        type: 'Residency Certificate',
                        date: '2023-11-20',
                        status: 'Issued'
                    }
                ],
                complaints: [{
                    date: '2023-12-10',
                    type: 'Noise Complaint',
                    status: 'Pending'
                }],
                activities: [{
                    date: '2023-12-20',
                    activity: 'Community Clean-up',
                    participation: 'Attended'
                }]
            };

            // Populate modal with resident data
            populateResidentModal(residentData);

            // Show modal
            const viewModal = new bootstrap.Modal(document.getElementById('viewResidentModal'));
            viewModal.show();
        }

        // Populate resident modal with data
        function populateResidentModal(data) {
            const modal = document.getElementById('viewResidentModal');

            // Populate main details
            modal.querySelector('.resident-name').textContent = data.name;
            modal.querySelector('.resident-id').textContent = data.id;
            modal.querySelector('.resident-dob').textContent = data.dob;
            modal.querySelector('.resident-age').textContent = data.age;
            modal.querySelector('.resident-gender').textContent = data.gender;
            modal.querySelector('.resident-civil-status').textContent = data.civilStatus;
            modal.querySelector('.resident-contact').textContent = data.contact;
            modal.querySelector('.resident-address').textContent = data.address;
            modal.querySelector('.resident-email').textContent = data.email;
            modal.querySelector('.resident-reg-date').textContent = data.regDate;

            // Populate documents table
            const documentsHtml = data.documents.map(doc => `
                <tr>
                    <td>${doc.type}</td>
                    <td>${doc.date}</td>
                    <td><span class="badge bg-success">${doc.status}</span></td>
                </tr>
            `).join('');
            document.getElementById('documentsList').innerHTML = documentsHtml;

            // Populate complaints table
            const complaintsHtml = data.complaints.map(complaint => `
                <tr>
                    <td>${complaint.date}</td>
                    <td>${complaint.type}</td>
                    <td><span class="badge bg-warning">${complaint.status}</span></td>
                </tr>
            `).join('');
            document.getElementById('complaintsList').innerHTML = complaintsHtml;

            // Populate activities table
            const activitiesHtml = data.activities.map(activity => `
                <tr>
                    <td>${activity.date}</td>
                    <td>${activity.activity}</td>
                    <td><span class="badge bg-success">${activity.participation}</span></td>
                    <td><span class="badge bg-success">${activity.status}</span></td>
                </tr>
            `).join('');
            document.getElementById('activitiesList').innerHTML = activitiesHtml;
        }
    </script>
</body>

</html>
