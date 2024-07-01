<?php
session_start();

if (!isset($_SESSION['adminid'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
	<style>
    .drop-zone {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        font-size: 1.2em;
        margin: 20px;
        cursor: pointer;
    }
</style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['adminusername']); ?>!</h2>
    <p>This is the admin panel.</p>
	
	<div class="drop-zone" id="drop-zone">
    Drag & Drop CSV file here or click to select files
	</div>

	<script>
	// JavaScript to handle drag-and-drop functionality
		const dropZone = document.getElementById('drop-zone');

		dropZone.addEventListener('dragover', function(e) {
			e.preventDefault();
			dropZone.classList.add('highlight');
		});

		dropZone.addEventListener('dragleave', function(e) {
			e.preventDefault();
			dropZone.classList.remove('highlight');
		});

		dropZone.addEventListener('drop', function(e) {
			e.preventDefault();
			dropZone.classList.remove('highlight');
			
			const files = e.dataTransfer.files;
			handleFiles(files);
		});

		dropZone.addEventListener('click', function() {
			const fileInput = document.createElement('input');
			fileInput.type = 'file';
			fileInput.accept = '.csv';
			fileInput.onchange = function(e) {
				const files = e.target.files;
				handleFiles(files);
			};
			fileInput.click();
		});

		function handleFiles(files) {
			const file = files[0];
			if (file.type === 'text/csv') {
				uploadFile(file);
			} else {
				alert('Please upload a CSV file.');
			}
		}

		function uploadFile(file) {
			const formData = new FormData();
			formData.append('file', file);

			fetch('upload_and_load.php', {
				method: 'POST',
				body: formData
			})
			.then(response => response.text())
			.then(result => {
				alert(result); // Display the result from PHP (e.g., "Data loaded successfully")
			})
			.catch(error => console.error('Error:', error));
		}
	</script>
	
    <a href="logout.php">Logout</a>
</body>
</html>
