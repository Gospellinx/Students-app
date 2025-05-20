<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Student Management System</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        <i class="fas fa-plus"></i> Add Student
    </button>

    <input type="text" id="searchBar" class="form-control mb-3" placeholder="Search students..." onkeyup="searchStudents()">

    <div class="table-container">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <div class="mb-3">
                        <label>Name:</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Age:</label>
                        <input type="number" id="age" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', loadStudents);

// Fetch Students from Server
function loadStudents() {
    fetch('fetch_students.php')
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById('studentTableBody');
            tableBody.innerHTML = '';
            data.forEach(student => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${student.id}</td>
                        <td>${student.name}</td>
                        <td>${student.email}</td>
                        <td>${student.age}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editStudent(${student.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="deleteStudent(${student.id})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
        });
}

// Search Function
function searchStudents() {
    let input = document.getElementById("searchBar").value.toLowerCase();
    let rows = document.querySelectorAll("#studentTableBody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}

// Add Student
document.getElementById('addStudentForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let age = document.getElementById('age').value;

    fetch('add_student.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `name=${name}&email=${email}&age=${age}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadStudents();
        document.getElementById('addStudentForm').reset();
        new bootstrap.Modal(document.getElementById('addStudentModal')).hide();
    });
});

// Delete Student
function deleteStudent(id) {
    if (confirm("Are you sure you want to delete this student?")) {
        fetch('delete_student.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadStudents();
        });
    }
}
</script>

</body>
</html>
