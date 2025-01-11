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
        @include('secretary.components.sidebar')

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Header with Barangay Information -->
            <div class="barangay-header p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 mb-1">Residents Management</h1>
                        <p class="lead mb-0">Track and Monitor Residents</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userMenu"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>Secretary
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i
                                            class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content p-4">
                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card h-100" style="border-left: 4px solid #3498db;">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Total Residents</h6>
                                <h2 class="card-title mb-0">1,234</h2>
                                <div class="text-muted small mt-1">Registered residents</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100" style="border-left: 4px solid #2ecc71;">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Senior Citizens</h6>
                                <h2 class="card-title mb-0">156</h2>
                                <div class="text-success small mt-1">12.6% of population</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100" style="border-left: 4px solid #e74c3c;">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Households</h6>
                                <h2 class="card-title mb-0">312</h2>
                                <div class="text-danger small mt-1">Active households</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100" style="border-left: 4px solid #f1c40f;">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">New Registrations</h6>
                                <h2 class="card-title mb-0">15</h2>
                                <div class="text-warning small mt-1">This month</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Residents List Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Residents Details</h5>
                            <div class="d-flex align-items-center gap-3">
                                <div class="search-bar">
                                    <i class="bi bi-search"></i>
                                    <input type="text" class="form-control" id="residentSearchInput"
                                        placeholder="Search residents...">
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#newResidentModal">
                                    <i class="bi bi-plus me-2"></i>Add New Resident
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- filepath: /c:/Users/vivoxie/Capstone/Laravel/playground/resources/views/secretary/residents.blade.php -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residents as $resident)
                                        <tr>
                                            <td>{{ $resident->id }}</td>
                                            <td>{{ $resident->first_name }} {{ $resident->last_name }}</td>
                                            <td class="resident-age" data-dob="{{ $resident->date_of_birth }}"></td>
                                            <td>{{ $resident->address }}</td>
                                            <td>{{ $resident->contact_number }}</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="viewResident('{{ $resident->id }}')">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                    <form id="newResidentForm" class="needs-validation" method="POST"
                        action="{{ route('secretary.residents.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    required>
                                <div class="invalid-feedback">Please enter a first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                                <div class="invalid-feedback">Please enter a last name.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    required>
                                <div class="invalid-feedback">Please select a date of birth.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Civil Status</label>
                                <select class="form-select" id="civil_status" name="civil_status" required>
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
                            <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                            <div class="invalid-feedback">Please enter an address.</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contact_number" name="contact_number"
                                    pattern="[0-9]{11}" required>
                                <div class="invalid-feedback">Please enter a valid 11-digit contact number.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="registerResidentBtn">Register
                                Resident</button>
                        </div>
                    </form>
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
                        first_name: document.getElementById('first_name').value,
                        last_name: document.getElementById('last_name').value,
                        date_of_birth: document.getElementById('date_of_birth').value,
                        gender: document.getElementById('gender').value,
                        civil_status: document.getElementById('civil_status').value,
                        address: document.getElementById('address').value,
                        contact_number: document.getElementById('contact_number').value,
                        email: document.getElementById('email').value
                    };

                    // Submit the form data via AJAX or any other method
                    console.log(formData);
                }

                form.classList.add('was-validated');
            });

            // Calculate and display age
            function calculateAge(dateOfBirth) {
                const dob = new Date(dateOfBirth);
                const today = new Date();

                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                return age;
            }

            const ageElements = document.querySelectorAll('.resident-age');
            ageElements.forEach(element => {
                const dob = element.getAttribute('data-dob');
                if (dob) {
                    element.textContent = calculateAge(dob);
                }
            });
        });




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

        function viewResident(id) {
            fetch(`/residents/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Calculate age from date of birth
                    const dob = new Date(data.date_of_birth);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }

                    document.querySelector('.resident-name').textContent = `${data.first_name} ${data.last_name}`;
                    document.querySelector('.resident-id').textContent = data.id;
                    document.querySelector('.resident-dob').textContent = new Date(data.date_of_birth)
                        .toLocaleDateString();
                    document.querySelector('.resident-age').textContent = age;
                    document.querySelector('.resident-gender').textContent = data.gender;
                    document.querySelector('.resident-civil-status').textContent = data.civil_status;
                    document.querySelector('.resident-contact').textContent = data.contact_number;
                    document.querySelector('.resident-address').textContent = data.address;
                    document.querySelector('.resident-email').textContent = data.email || 'N/A';
                    document.querySelector('.resident-reg-date').textContent = new Date(data.created_at)
                        .toLocaleDateString();

                    // Show the modal
                    var viewResidentModal = new bootstrap.Modal(document.getElementById('viewResidentModal'));
                    viewResidentModal.show();
                })
                .catch(error => console.error('Error fetching resident details:', error));
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
