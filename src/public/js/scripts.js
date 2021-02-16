/*!
    * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    (function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

const customSelects = document.querySelectorAll("select");
const deleteBtn = document.getElementById('delete')

for (let i = 0; i < customSelects.length; i++)
{
  customSelects[i].addEventListener('addItem', function(event)
  {
    if (event.detail.value)
    {
      let parent = this.parentNode.parentNode
      parent.classList.add('valid')
      parent.classList.remove('invalid')
    }
    else
    {
      let parent = this.parentNode.parentNode
      parent.classList.add('invalid')
      parent.classList.remove('valid')
    }
  }, false);
}


function showadvanced(){
    $('.advance-search').toggleClass('d-none');
    $('.result-count').toggleClass('d-none');
}


/// This is part for modals
function modalFade(){
    $(".modal").addClass('d-none');
}

function deleteDriver(id){
  $('#deleteDriver').removeClass('d-none');
  $('#id_driver_delete').val(id);
  
}
function deleteLoad(id){
  $('#deleteLoad').removeClass('d-none');
  $('#id_load_delete').val(id);
  
}



function checkdistance() {
  var lonconsignee = $("#lon_consignee").val();
  var latconsignee = $("#lat_consignee").val();
  var lonshipper = $("#lon_shipper").val();
  var latshipper = $("#lat_shipper").val();
  if (lonconsignee && latconsignee && lonshipper && latshipper) {
    var jsonrequest =
      "https://us1.locationiq.com/v1/directions/driving/" +
      lonshipper +
      "," +
      latshipper +
      ";" +
      lonconsignee +
      "," +
      latconsignee +
      "?overview=false&key=0ffa417459841a";
    xhr = new XMLHttpRequest();
    xhr.open("GET", jsonrequest, true);
    xhr.onload = function () {
      if (this.status == 200) {
        var location = JSON.parse(this.responseText);

        var dist = location.routes[0].distance;
        (dist = dist / 1609), 34;
        dist = dist.toFixed(0);

        $("#distance_load").val(dist);
      } else {
        $("#distance_load").val("Calculation erro");
      }
    };

    xhr.send();
  }
}
