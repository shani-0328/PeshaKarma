var table = table = $('#example').DataTable({});

$('#firstDropdownId').on('change', function() {
    table.columns(4).search(this.value).draw();
});

$('#SecondDropdownId').on('change', function() {
    table.columns(3).search(this.value).draw();
});