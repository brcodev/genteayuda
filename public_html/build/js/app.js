$(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#registros').DataTable({ 
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "language": { 
        paginate: {
          next: 'Siguiente',
          previous: 'Anterior',
          last: 'Último',
          first: 'Primero'
        },
          info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados', 
          emptyTable: 'No hay registros',
          infoEmpty: '0 Registros',
          search: 'Buscar:'

      }
    });

    $('#summernote').summernote({
      height: 300,                 
      minHeight: null,             
      maxHeight: null,                           

  });

      $('.select2').select2();
  
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      });

      $('#icono').iconpicker();

  });