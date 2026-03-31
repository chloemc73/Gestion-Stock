
function suggestion_name() {

     $('#sug_input').keyup(function(e) {

         var formData = {
             'product_name' : $('input[name=title]').val()
         };

         if(formData['product_name'].length >= 1){

           // traiter le formulaire
           $.ajax({
               type        : 'POST',
               url         : 'ajax.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

 }
  $('#sug-form').submit(function(e) {
      var formData = {
          'p_name' : $('input[name=title]').val()
      };
        // traiter le formulaire
        $.ajax({
            type        : 'POST',
            url         : 'ajax.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                $('#product_info').html(data).show();
                total();
                $('.datePicker').datepicker('update', new Date());

            }).fail(function() {
                $('#product_info').html(data).show();
            });
      e.preventDefault();
  });


function suggestion_sku() {

     $('#sug_sku_input').keyup(function(e) {

         var formData = {
             'product_sku' : $('input[name=sku]').val()
         };

         if(formData['product_sku'].length >= 1){

           // traiter le formulaire
           $.ajax({
               type        : 'POST',
               url         : 'ajax_sku.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_sku_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_sku_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

 }
  $('#sug-sku-form').submit(function(e) {
      var formData = {
          'p_sku' : $('input[name=sku]').val()
      };
        // traiter le formulaire
        $.ajax({
            type        : 'POST',
            url         : 'ajax_sku.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                $('#product_info').html(data).show();
                total();
                $('.datePicker').datepicker('update', new Date());

            }).fail(function() {
                $('#product_info').html(data).show();
            });
      e.preventDefault();
  });

function suggestion_customer() {

     $('#sug_customer_input').keyup(function(e) {

         var formData = {
             'customer_name' : $('input[name=customer_name]').val()
         };

         if(formData['customer_name'].length >= 1){

           // traiter le formulaire
           $.ajax({
               type        : 'POST',
               url         : 'ajax_customer.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_customer_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_customer_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

 }
  $('#sug-customer-form').submit(function(e) {
      var formData = {
          'c_name' : $('input[name=customer_name]').val()
      };
        // traiter le formulaire
        $.ajax({
            type        : 'POST',
            url         : 'ajax_customer.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                $('#customer_info').html(data).show();
                total();
                $('.datePicker').datepicker('update', new Date());

            }).fail(function() {
                $('#customer_info').html(data).show();
            });
      e.preventDefault();
  });



function suggestion_search() {

     $('#sug_search_input').keyup(function(e) {

         var formData = {
             'product_search' : $('input[name=product_search]').val()
         };

         if(formData['product_search'].length >= 1){

           // traiter le formulaire
           $.ajax({
               type        : 'POST',
               url         : 'ajax_product.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_search_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_search_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

 }
  $('#sug-search-form').submit(function(e) {
      var formData = {
          'p_search' : $('input[name=product_search]').val()
      };
        // traiter le formulaire
        $.ajax({
            type        : 'POST',
            url         : 'ajax_product.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                // Cette ligne affiche le contenu de "data" dans la console 
                   // du navigateur pour faciliter le débogage et vérifier les 
                   // données reçues;
                $('#product_info').html(data).show();
                total();
                $('.datePicker').datepicker('update', new Date());

            }).fail(function() {
                $('#product_info').html(data).show();
            });
      e.preventDefault();
  });








  function total(){
    $('#product_info input').change(function(e)  {
            var price = +$('input[name=price]').val() || 0;
            var qty   = +$('input[name=quantity]').val() || 0;
            var totale = qty * prix ;
                $('input[name=total]').val(total.toFixed(2));
    });
  }

  $(document).ready(function() {

    // info-bulle
    $('[data-toggle="tooltip"]').tooltip();

    $('.submenu-toggle').click(function () {
       $(this).parent().children('ul.submenu').toggle(200);
    });
    // suggestion pour trouver les noms de produits
    suggestion_name();
   // suggestion pour trouver les noms de produits
    suggestion_sku();
    // suggestion pour trouver les noms de produits
    suggestion_customer();
    // suggestion pour trouver les noms de produits
    suggestion_search();
    // Calculer le montant total
    total();

    $('.datepicker')
        .datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true
        });
  });


  // Fonction de basculement du mode sombre
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    
    // Vérifier si la préférence de l'utilisateur est stockée dans localStorage
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    // Appliquer la préférence sauvegardée ou utiliser la préférence du système
    if (isDarkMode) {
      document.documentElement.classList.add('dark');
    } else if (localStorage.getItem('darkMode') === 'false') {
      document.documentElement.classList.remove('dark');
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.classList.add('dark');
    }
    
    // Bascule du mode sombre lors du clic sur le bouton
    darkModeToggle.addEventListener('click', function() {
      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'false');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
      }
    });
    
    // Mettre à jour l'état du bouton en fonction du mode actuel
    function updateButtonState() {
      if (document.documentElement.classList.contains('dark')) {
        darkModeToggle.setAttribute('aria-label', 'Switch to light mode');
      } else {
        darkModeToggle.setAttribute('aria-label', 'Switch to dark mode');
      }
    }
    
    // Mettre à jour l'état du bouton initialement et lors d'un changement de mode
    updateButtonState();
    darkModeToggle.addEventListener('click', updateButtonState);
    
    // Écouter également les changements de préférence du système
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
      if (localStorage.getItem('darkMode') === null) {
        if (event.matches) {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
        updateButtonState();
      }
    });
  });