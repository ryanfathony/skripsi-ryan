<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; SKRIPSI <?= date('Y'); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- CKeditor -->
<script src="<?= base_url('assets/'); ?>vendor/ckeditor/ckeditor.js"></script>

<!-- Buttons -->
<script src="<?= base_url('assets/'); ?>vendor/buttons-1.6.2/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/buttons-1.6.2/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/buttons-1.6.2/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/buttons-1.6.2/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/buttons-1.6.2/js/buttons.colVis.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>


<!-- <script>
    $(document).ready(function() {
        // Sembunyikan alert validasi kosong
        $("#kosong").hide();
    });
</script> -->

<script>
    //add-knowledge
    $(function() {
        $("#jenis_yes").change(function() {

            if ($(this).val() == "kecerdasan_yes") {
                $("#kriteria_yes").hide();
                $("#kecerdasan_yes").show();
            } else if ($(this).val() == "kriteria_yes") {
                $("#kriteria_yes").show();
                $("#kecerdasan_yes").hide();
            } else {
                $("#kriteria_yes").hide();
                $("#kecerdasan_yes").hide();
            }
        });
    });

    $(function() {
        $("#jenis_no").change(function() {

            if ($(this).val() == "kecerdasan_no") {
                $("#kriteria_no").hide();
                $("#kecerdasan_no").show();
            } else if ($(this).val() == "kriteria_no") {
                $("#kriteria_no").show();
                $("#kecerdasan_no").hide();
            } else {
                $("#kriteria_no").hide();
                $("#kecerdasan_no").hide();
            }
        });
    });
</script>

<script>
    $('.custom-file-input').on('change',
        function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

    $('.form-check-input').on('click',
        function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('admin/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                }
            });
        });
</script>

<script>
    $(function() {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1')
        CKEDITOR.replace('editor2')
        CKEDITOR.replace('editor3')
        CKEDITOR.replace('editor4')
        CKEDITOR.replace('editor5')
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5()
    })
</script>

</body>

</html>