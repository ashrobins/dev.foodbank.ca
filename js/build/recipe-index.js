(function($){


var $default_serving_size = 15,
    small_serving_size = 15,
    medium_serving_size = 50,
    large_serving_size = 100;


acf.add_action('ready', function(){

  var duplicate_button = $('<button/>', {
                  id: 'mighty-duplicatior',
                  class: 'theduplicator',
                  type: 'button',
                  html: 'Sizify the recipe'
                 });


  $('#acf-group_53597bf62149d').prepend(duplicate_button);
  $(document).on("click", "#mighty-duplicatior", function(){recipe_sizing_magic()});
});



function recipe_sizing_magic(){
    // update global variable
     $default_serving_size = $('#acf-field_53597ee885779').val();
     console.log($default_serving_size);

  var 
      $ingredients          = $('.field_key-field_53597c16bfbb7 tr.acf-row:not(:last-child)'),
      default_amount        = '.field_key-field_53597d4dc9b62 input',
      default_measurement   = '.field_key-field_53597de3d1204 input',
      default_ingredient    = '.field_key-field_53597e17d1205 input',
      small_recipe_tinymce  = '.field_key-field_53a91c6835345 .acf-wysiwyg-wrap',
      medium_recipe_tinymce = '.field_key-field_53d6ddacc3101 .acf-wysiwyg-wrap',
      large_recipe_tinymce  = '.field_key-field_53d6ddd8c3102 .acf-wysiwyg-wrap',
      small_list            = [],
      medium_list           = [],
      large_list            = [],
      small_ingredient_list, 
      medium_ingredient_list,       
      large_ingredient_list;



      $ingredients.each(function(){
        var measurement = $(this).find(default_measurement).val().toLowerCase(),
            amount      = convert_fractions($(this).find(default_amount).val()),
            ingredient  = $(this).find(default_ingredient).val();

          if (measurement.length > 0) {
            var unit = measurement
          }
          else {
            var unit = "";
          }

      if (ingredient){
        small_list.push(
          "<li>" +
            convert(amount,unit,small_serving_size)
            +" " + ingredient + "</li>"
            );

        large_list.push(
          "<li>" +
            convert(amount,unit,large_serving_size)
            +" " + ingredient + "</li>"
          );

        medium_list.push(
          "<li>" +
            convert(amount,unit,medium_serving_size)
            +" " + ingredient + "</li>"
            );
      }


        });
      //end each ingredient filter

        

      small_ingredient_list = small_list.join("");
      medium_ingredient_list = medium_list.join("");          
      large_ingredient_list = large_list.join("");

      update_portioned_recipes(medium_recipe_tinymce, medium_ingredient_list);
      update_portioned_recipes(small_recipe_tinymce, small_ingredient_list);
      update_portioned_recipes(large_recipe_tinymce, large_ingredient_list);
     
    }
    //end recipe sizing magic

function update_portioned_recipes(tinymce_field,recipe){
  var 
      iframeid = $(tinymce_field)
                  .attr('id')
                  .split("wp-"),
                  mechanic,
                  editor,
                  tinymc_id;

      tinymc_id = iframeid[1].split("-wrap");

  editor = tinyMCE.get(tinymc_id[0]);
  editor.setContent(recipe);
}

// Start converter functions
function convert_fractions(amount){
  var array = amount.split(" ");
  if (array.length > 1) {
    var split = array[1].split("/")
    var result = parseInt(split[0], 10) / parseInt(split[1], 10);
    console.log(result);
    console.log(array[0]);
    console.log(parseInt(array[0], 10) + result)
    return (parseInt(array[0], 10) + result);

  }
  else {
    var fraction_test = amount.split("/");
    if (fraction_test.length > 1 ){
      var result = parseInt(fraction_test[0], 10) / parseInt(fraction_test[1], 10);
      return result;

    }
    else{
       return amount;

    }
  }
}
function convert(amount, measurement, serving_size){
    var multiplier = (serving_size/$default_serving_size)
    var new_amount = (amount * multiplier)
    switch(measurement){
      case "tsp":
      case "teaspoon":
        return convert_tsp(new_amount);
        break;
      case "tbs":
      case "tbsp":
      case "tablespoon":
      case "tablespoons":
        return convert_tbs(new_amount);
        break;
      case "c":
      case "cup":
      case "cups":
        return convert_cups(new_amount);
        break;
      case "oz":
        return convert_oz(new_amount);
        break;
      case "ml":
        return convert_ml(new_amount);
      case "lb":
      case "lbs":
        return convert_lb(new_amount);
      case "gallon":
      case "gallons":
        return convert_gallon(new_amount);
      default:
        return convert_generic(new_amount, measurement);
        break;
    };


}

function convert_tsp(amount){
  if (amount > 3) {
    return convert_tbs(amount/3);
  }
  else {
    return update_measurement(amount, "tsp", "tsp");
  }

}

function convert_ml(amount){
  if (amount > 1000){
    return convert_litres(amount/1000);
  }
  else {
    return update_measurement(amount, "ml", "ml");
  }
}

function convert_litres(amount){
  return update_measurement(amount, "litres", "litre");
}

function convert_tbs(amount){
  if (amount > 4) {
    return convert_cups(amount/16)
  }
  else {
    return update_measurement(amount, "tbs", "tbs");
  }

}

function convert_cups(amount){
  if (amount > 4) {
    return convert_quart(amount/4)
  }
  else {
    return update_measurement(amount, "cups", "cup");
  }

}

function convert_quart(amount){
  if (amount > 4){
    return convert_gallon(amount/4)
  }
  else {
    return update_measurement(amount, "quarts", "quart")
  }

}

function convert_gallon(amount){
  return update_measurement(amount, "gallons", "gallon");
}

function convert_lb(amount){
  return update_measurement(amount, "lbs", "lb");
}

function convert_oz(amount, measurement){
  return update_measurement(amount, "oz", "oz");
}

function convert_generic(amount, measurement){
  return update_measurement(amount, measurement, measurement);
}

function update_measurement(amount, measurement, singular){
  var quantity = roundToNearest(amount),
      updated_amount = quantity + " " + measurement,
      singular_amount = quantity + " " + singular;
      console.log(singular_amount);
      console.log(quantity);

  if (quantity == 1){
    return singular_amount;
  }
  else {
    return updated_amount;

  }

}


// function roundToNearest( number, multiple ){
//   var half = multiple/2;
//   return number+half - (number+half) % multiple;
// }

function roundToNearest(amount){
  var wholenumber = Math.floor(amount),
      decimal = amount - wholenumber,
      fraction,
      quantity;

  if (decimal < 0.125){
    decimal = 0;
    fraction = "";
  }
  else if (decimal < 0.29){
    decimal = 0.25;
    fraction = "<sup>1</sup>/<sub>4</sub>";
  }
  else if (decimal < 0.415){
    decimal = 0.33;
    fraction = "<sup>1</sup>/<sub>3</sub>";
  }
  else if (decimal < 0.58){
    decimal = 0.5;
    fraction = "<sup>1</sup>/<sub>2</sub>";
  }
  else if (decimal < 0.705){
    decimal = 0.66;
    fraction = "<sup>2</sup>/<sub>3</sub>";
  }
  else if (decimal < .875){
    decimal = 0.75;
    fraction = "<sup>3</sup>/<sub>4</sub>";
  }
  else {
    decimal = 0;
    fraction = "";
    wholenumber += 1;
  }

  if (wholenumber == 0) {
    quantity = "<span class='ingredient-fraction'>" + fraction + "</span>";
  }
  else if (fraction.length > 1) {
    quantity = wholenumber.toString() + " <span class='ingredient-fraction'>" + fraction + "</span>";

  }
  else {
    quantity = wholenumber.toString();
  }
  
  return quantity;
  
}




})(jQuery);







var default_serving_size = 15;

function convert(amount, measurement, serving_size){
    var multiplier = (serving_size/default_serving_size)
    var new_amount = (amount * multiplier)
    switch(measurement){
      case "tsp":
      case "teaspoon":
        convert_tsp(new_amount);
        break;
      case "tbs":
      case "tablespoon":
      case "tablespoons":
        convert_tbs(new_amount);
        break;
      case "c":
      case "cup":
      case "cups":
        convert_cups(new_amount);
        break;
      case "oz":
        convert_oz(new_amount);
        break;
      default:
        convert_generic(new_amount, measurement);
        break;
    };


}

function convert_tsp(amount){
  if (amount > 3) {
    convert_tbs(amount/3);
  }
  else {
    update_measurement(amount, "tsp");
  }

}

function convert_tbs(amount){
  if (amount > 4) {
    convert_cups(amount/16)
  }
  else {
    update_measurement(amount, "tbs");
  }

}

function convert_cups(amount){
  if (amount > 4) {
    convert_quart(amount/4)
  }
  else {
    update_measurement(amount, "cups");
  }

}

function convert_quart(amount){
  if (amount > 4){
    convert_gallon(amount/4)
  }
  else {
    update_measurement(amount, "quarts")
  }

}

function convert_gallon(amount){
  update_measurement(amount, "gallons");
}

function convert_generic(amount, measurement){
  update_measurement(amount, measurement);
}

function update_measurement(amount, measurement){
  var quantity = roundToNearest(amount, .25);
  var updated_amount = quantity + " "+ measurement;
  console.log(updated_amount);
}


function roundToNearest( number, multiple ){
  var half = multiple/2;
  return number+half - (number+half) % multiple;
}

/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
  // Site title and description.
  wp.customize( 'blogname', function( value ) {
    value.bind( function( to ) {
      $( '.site-title a' ).text( to );
    } );
  } );
  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( to ) {
      $( '.site-description' ).text( to );
    } );
  } );
  // Header text color.
  wp.customize( 'header_textcolor', function( value ) {
    value.bind( function( to ) {
      if ( 'blank' === to ) {
        $( '.site-title, .site-description' ).css( {
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        } );
      } else {
        $( '.site-title, .site-description' ).css( {
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        } );
      }
    } );
  } );
} )( jQuery );

/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
  var container, button, menu;

  container = document.getElementById( 'site-navigation' );
  if ( ! container )
    return;

  button = container.getElementsByTagName( 'h1' )[0];
  if ( 'undefined' === typeof button )
    return;

  menu = container.getElementsByTagName( 'ul' )[0];

  // Hide menu toggle button if menu is empty and return early.
  if ( 'undefined' === typeof menu ) {
    button.style.display = 'none';
    return;
  }

  if ( -1 === menu.className.indexOf( 'nav-menu' ) )
    menu.className += ' nav-menu';

  button.onclick = function() {
    if ( -1 !== container.className.indexOf( 'toggled' ) )
      container.className = container.className.replace( ' toggled', '' );
    else
      container.className += ' toggled';
  };
} )();

( function() {
  var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
      is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
      is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

  if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
    var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
    window[ eventMethod ]( 'hashchange', function() {
      var element = document.getElementById( location.hash.substring( 1 ) );

      if ( element ) {
        if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
          element.tabIndex = -1;

        element.focus();
      }
    }, false );
  }
})();
