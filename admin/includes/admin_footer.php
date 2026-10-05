<?php
$year = date('Y');
?>
    </div><!-- admin-content -->
    <footer class="text-center text-muted py-3">
        <small>&copy; <?php echo $year; ?> LIVEpro Software Solutions | Admin Panel</small>
    </footer>
</div><!-- main column -->
</div><!-- row -->
</div><!-- container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize TinyMCE on all rich-text editors
    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: 'link image code lists table',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
        menubar: false,
        height: 350
    });
</script>
</body>
</html>
