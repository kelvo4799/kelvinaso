@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flash("{{ session('error') }}", 'error', 'Error');
        });
    </script>
@endif

@if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flash("{{ session('warning') }}", 'warning', 'Warning');
        });
    </script>
@endif

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flash("{{ session('success') }}", 'success', 'Success');
        });
    </script>
@endif