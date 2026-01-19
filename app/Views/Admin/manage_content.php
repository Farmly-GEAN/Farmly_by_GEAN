<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Content - Admin</title>
    <style>
        
        textarea {
            width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 6px;
            font-size: 1rem; font-family: "Segoe UI", sans-serif; transition: 0.3s; resize: vertical; min-height: 120px;
        }
        textarea:focus { border-color: #3498db; outline: none; }
        
        .btn-save {
            background: #27ae60; color: white; padding: 12px 20px; border: none; border-radius: 6px;
            font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 15px; display: inline-block;
        }
        .btn-save:hover { background: #219150; }
        
        .alert-success {
            background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 25px; border: 1px solid #c3e6cb;
        }
    </style>
    <style>
        .dashboard-container { display: flex; height: 100vh; width: 100%; }
        .main-content { flex: 1; padding: 30px; overflow-y: auto; background: #f0f2f5; }
    </style>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
</head>
<body>

    <div class="dashboard-container">

        <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

        <div class="main-content">
            
            <div class="top-bar">
                <h2>Manage Site Content</h2>
                <div class="user-info">Admin Panel</div>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert-success">Content updated successfully!</div>
            <?php endif; ?>

            <div class="card" style="margin-bottom: 30px;">
                <h3>Home Page: Welcome Message</h3>
                <form action="index.php?page=admin_update_content" method="POST">
                    <input type="hidden" name="content_type" value="home_welcome">
                    <textarea name="content_text"><?php echo htmlspecialchars($home_welcome ?? ''); ?></textarea>
                    <button type="submit" class="btn-save">Update Message</button>
                </form>
            </div>

            <div class="card" style="margin-bottom: 30px;">
                <h3>Terms & Conditions</h3>
                <form action="index.php?page=admin_update_content" method="POST">
                    <input type="hidden" name="content_type" value="terms_content">
                    <textarea name="content_text" style="height: 200px;"><?php echo htmlspecialchars($terms_content ?? ''); ?></textarea>
                    <button type="submit" class="btn-save">Update Terms</button>
                </form>
            </div>

            <div class="card" style="margin-bottom: 30px;">
                <h3>Legal Notices</h3>
                <form action="index.php?page=admin_update_content" method="POST">
                    <input type="hidden" name="content_type" value="legal_notice">
                    <textarea name="content_text" style="height: 150px;"><?php echo htmlspecialchars($legal_content ?? ''); ?></textarea>
                    <button type="submit" class="btn-save">Update Legal Notice</button>
                </form>
            </div>

        </div> 
    </div> 

    <script>
        
        const successMsg = document.querySelector('.alert-success');

        if (successMsg) {
            
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?page=admin_content';
            window.history.replaceState({path: newUrl}, '', newUrl);

            
            setTimeout(() => {
                successMsg.style.transition = "opacity 0.5s ease"; 
                successMsg.style.opacity = "0"; 
                
                
                setTimeout(() => successMsg.remove(), 500); 
            }, 3000); 
        }
    </script>
    </body>
</html>