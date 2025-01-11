<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <div class="barangay-logo">
            <img src="logo.png" class="img-fluid" alt="Barangay Logo">
        </div>
        <h4>Barangay Cantil-E</h4>
        <p>Official Portal</p>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('secretary.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a class="nav-link" href="documents.html">
            <i class="bi bi-file-earmark-text me-2"></i> Documents
        </a>
        <a class="nav-link" href="complaints.html">
            <i class="bi bi-exclamation-triangle me-2"></i> Complaints
        </a>
        <a class="nav-link" href="barangay_project.html">
            <i class="bi bi-building me-2"></i> Barangay Projects
        </a>
        <a class="nav-link" href="schedule.html">
            <i class="bi bi-calendar-event me-2"></i> Schedule
        </a>
        <a class="nav-link" href="inventory.html">
            <i class="bi bi-box-seam me-2"></i> Inventory
        </a>
        <a class="nav-link active" href="{{ route('secretary.residents') }}">
            <i class="bi bi-people me-2"></i> Residents
        </a>
        <a class="nav-link" href="{{ route('secretary.activity') }}">
            <i class="bi bi-activity me-2"></i> Activity Logs
        </a>
    </nav>
</div>
