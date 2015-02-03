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

/*!
 * iconic.js v0.4.0 - The Iconic JavaScript library
 * Copyright (c) 2014 Waybury - http://useiconic.com
 */

!function(a){"object"==typeof exports?module.exports=a():"function"==typeof define&&define.amd?define(a):"undefined"!=typeof window?window.IconicJS=a():"undefined"!=typeof global?global.IconicJS=a():"undefined"!=typeof self&&(self.IconicJS=a())}(function(){var a;return function b(a,c,d){function e(g,h){if(!c[g]){if(!a[g]){var i="function"==typeof require&&require;if(!h&&i)return i(g,!0);if(f)return f(g,!0);throw new Error("Cannot find module '"+g+"'")}var j=c[g]={exports:{}};a[g][0].call(j.exports,function(b){var c=a[g][1][b];return e(c?c:b)},j,j.exports,b,a,c,d)}return c[g].exports}for(var f="function"==typeof require&&require,g=0;g<d.length;g++)e(d[g]);return e}({1:[function(a,b){var c=(a("./modules/polyfills"),a("./modules/svg-injector")),d=a("./modules/extend"),e=a("./modules/responsive"),f=a("./modules/position"),g=a("./modules/container"),h=a("./modules/log"),i={},j=window.iconicSmartIconApis={},k=("file:"===window.location.protocol,0),l=function(a,b,e){b=d({},i,b||{});var f={evalScripts:b.evalScripts,pngFallback:b.pngFallback};f.each=function(a){if(a)if("string"==typeof a)h.debug(a);else if(a instanceof SVGSVGElement){var c=a.getAttribute("data-icon");if(c&&j[c]){var d=j[c](a);for(var e in d)a[e]=d[e]}/iconic-bg-/.test(a.getAttribute("class"))&&g.addBackground(a),m(a),k++,b&&b.each&&"function"==typeof b.each&&b.each(a)}},"string"==typeof a&&(a=document.querySelectorAll(a)),c(a,f,e)},m=function(a){var b=[];a?"string"==typeof a?b=document.querySelectorAll(a):void 0!==a.length?b=a:"object"==typeof a&&b.push(a):b=document.querySelectorAll("svg.iconic"),Array.prototype.forEach.call(b,function(a){a instanceof SVGSVGElement&&(a.update&&a.update(),e.refresh(a),f.refresh(a))})},n=function(){i.debug&&console.time&&console.time("autoInjectSelector - "+i.autoInjectSelector);var a=k;l(i.autoInjectSelector,{},function(){if(i.debug&&console.timeEnd&&console.timeEnd("autoInjectSelector - "+i.autoInjectSelector),h.debug("AutoInjected: "+(k-a)),e.refreshAll(),i.autoInjectDone&&"function"==typeof i.autoInjectDone){var b=k-a;i.autoInjectDone(b)}})},o=function(a){a&&""!==a&&"complete"!==document.readyState?document.addEventListener("DOMContentLoaded",n):document.removeEventListener("DOMContentLoaded",n)},p=function(a){return a=a||{},d(i,a),o(i.autoInjectSelector),h.enableDebug(i.debug),window._Iconic?window._Iconic:{inject:l,update:m,smartIconApis:j,svgInjectedCount:k}};b.exports=p,window._Iconic=new p({autoInjectSelector:"img.iconic",evalScripts:"once",pngFallback:!1,each:null,autoInjectDone:null,debug:!1})},{"./modules/container":2,"./modules/extend":3,"./modules/log":4,"./modules/polyfills":5,"./modules/position":6,"./modules/responsive":7,"./modules/svg-injector":8}],2:[function(a,b){var c=function(a){var b=a.getAttribute("class").split(" "),c=-1!==b.indexOf("iconic-fluid"),d=[],e=["iconic-bg"];Array.prototype.forEach.call(b,function(a){switch(a){case"iconic-sm":case"iconic-md":case"iconic-lg":d.push(a),c||e.push(a.replace(/-/,"-bg-"));break;case"iconic-fluid":d.push(a),e.push(a.replace(/-/,"-bg-"));break;case"iconic-bg-circle":case"iconic-bg-rounded-rect":case"iconic-bg-badge":e.push(a);break;default:d.push(a)}}),a.setAttribute("class",d.join(" "));var f=a.parentNode,g=Array.prototype.indexOf.call(f.childNodes,a),h=document.createElement("span");h.setAttribute("class",e.join(" ")),h.appendChild(a),f.insertBefore(h,f.childNodes[g])};b.exports={addBackground:c}},{}],3:[function(a,b){b.exports=function(a){return Array.prototype.forEach.call(Array.prototype.slice.call(arguments,1),function(b){if(b)for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c])}),a}},{}],4:[function(a,b){var c=!1,d=function(a){console&&console.log&&console.log(a)},e=function(a){d("Iconic INFO: "+a)},f=function(a){d("Iconic WARNING: "+a)},g=function(a){c&&d("Iconic DEBUG: "+a)},h=function(a){c=a};b.exports={info:e,warn:f,debug:g,enableDebug:h}},{}],5:[function(){Array.prototype.forEach||(Array.prototype.forEach=function(a,b){"use strict";if(void 0===this||null===this||"function"!=typeof a)throw new TypeError;var c,d=this.length>>>0;for(c=0;d>c;++c)c in this&&a.call(b,this[c],c,this)}),function(){if(Event.prototype.preventDefault||(Event.prototype.preventDefault=function(){this.returnValue=!1}),Event.prototype.stopPropagation||(Event.prototype.stopPropagation=function(){this.cancelBubble=!0}),!Element.prototype.addEventListener){var a=[],b=function(b,c){var d=this,e=function(a){a.target=a.srcElement,a.currentTarget=d,c.handleEvent?c.handleEvent(a):c.call(d,a)};if("DOMContentLoaded"==b){var f=function(a){"complete"==document.readyState&&e(a)};if(document.attachEvent("onreadystatechange",f),a.push({object:this,type:b,listener:c,wrapper:f}),"complete"==document.readyState){var g=new Event;g.srcElement=window,f(g)}}else this.attachEvent("on"+b,e),a.push({object:this,type:b,listener:c,wrapper:e})},c=function(b,c){for(var d=0;d<a.length;){var e=a[d];if(e.object==this&&e.type==b&&e.listener==c){"DOMContentLoaded"==b?this.detachEvent("onreadystatechange",e.wrapper):this.detachEvent("on"+b,e.wrapper);break}++d}};Element.prototype.addEventListener=b,Element.prototype.removeEventListener=c,HTMLDocument&&(HTMLDocument.prototype.addEventListener=b,HTMLDocument.prototype.removeEventListener=c),Window&&(Window.prototype.addEventListener=b,Window.prototype.removeEventListener=c)}}()},{}],6:[function(a,b){var c=function(a){var b=a.getAttribute("data-position");if(b&&""!==b){var c,d,e,f,g,h,i,j=a.getAttribute("width"),k=a.getAttribute("height"),l=b.split("-"),m=a.querySelectorAll("g.iconic-container");Array.prototype.forEach.call(m,function(a){if(c=a.getAttribute("data-width"),d=a.getAttribute("data-height"),c!==j||d!==k){if(e=a.getAttribute("transform"),f=1,e){var b=e.match(/scale\((\d)/);f=b&&b[1]?b[1]:1}g=Math.floor((j/f-c)/2),h=Math.floor((k/f-d)/2),Array.prototype.forEach.call(l,function(a){switch(a){case"top":h=0;break;case"bottom":h=k/f-d;break;case"left":g=0;break;case"right":g=j/f-c;break;case"center":break;default:console&&console.log&&console.log("Unknown position: "+a)}}),i=0===h?g:g+" "+h,i="translate("+i+")",e?/translate/.test(e)?e=e.replace(/translate\(.*?\)/,i):e+=" "+i:e=i,a.setAttribute("transform",e)}})}};b.exports={refresh:c}},{}],7:[function(a,b){var c=/(iconic-sm\b|iconic-md\b|iconic-lg\b)/,d=function(a,b){var c="undefined"!=typeof window.getComputedStyle&&window.getComputedStyle(a,null).getPropertyValue(b);return!c&&a.currentStyle&&(c=a.currentStyle[b.replace(/([a-z])\-([a-z])/,function(a,b,c){return b+c.toUpperCase()})]||a.currentStyle[b]),c},e=function(a){var b=a.style.display;a.style.display="block";var c=parseFloat(d(a,"width").slice(0,-2)),e=parseFloat(d(a,"height").slice(0,-2));return a.style.display=b,{width:c,height:e}},f=function(){var a="/* Iconic Responsive Support Styles */\n.iconic-property-fill, .iconic-property-text {stroke: none !important;}\n.iconic-property-stroke {fill: none !important;}\nsvg.iconic.iconic-fluid {height:100% !important;width:100% !important;}\nsvg.iconic.iconic-sm:not(.iconic-size-md):not(.iconic-size-lg), svg.iconic.iconic-size-sm{width:16px;height:16px;}\nsvg.iconic.iconic-md:not(.iconic-size-sm):not(.iconic-size-lg), svg.iconic.iconic-size-md{width:32px;height:32px;}\nsvg.iconic.iconic-lg:not(.iconic-size-sm):not(.iconic-size-md), svg.iconic.iconic-size-lg{width:128px;height:128px;}\nsvg.iconic-sm > g.iconic-md, svg.iconic-sm > g.iconic-lg, svg.iconic-md > g.iconic-sm, svg.iconic-md > g.iconic-lg, svg.iconic-lg > g.iconic-sm, svg.iconic-lg > g.iconic-md {display: none;}\nsvg.iconic.iconic-icon-sm > g.iconic-lg, svg.iconic.iconic-icon-md > g.iconic-lg {display:none;}\nsvg.iconic-sm:not(.iconic-icon-md):not(.iconic-icon-lg) > g.iconic-sm, svg.iconic-md.iconic-icon-sm > g.iconic-sm, svg.iconic-lg.iconic-icon-sm > g.iconic-sm {display:inline;}\nsvg.iconic-md:not(.iconic-icon-sm):not(.iconic-icon-lg) > g.iconic-md, svg.iconic-sm.iconic-icon-md > g.iconic-md, svg.iconic-lg.iconic-icon-md > g.iconic-md {display:inline;}\nsvg.iconic-lg:not(.iconic-icon-sm):not(.iconic-icon-md) > g.iconic-lg, svg.iconic-sm.iconic-icon-lg > g.iconic-lg, svg.iconic-md.iconic-icon-lg > g.iconic-lg {display:inline;}";navigator&&navigator.userAgent&&/MSIE 10\.0/.test(navigator.userAgent)&&(a+="svg.iconic{zoom:1.0001;}");var b=document.createElement("style");b.id="iconic-responsive-css",b.type="text/css",b.styleSheet?b.styleSheet.cssText=a:b.appendChild(document.createTextNode(a)),(document.head||document.getElementsByTagName("head")[0]).appendChild(b)},g=function(a){if(/iconic-fluid/.test(a.getAttribute("class"))){var b,d=e(a),f=a.viewBox.baseVal.width/a.viewBox.baseVal.height;b=1===f?Math.min(d.width,d.height):1>f?d.width:d.height;var g;g=32>b?"iconic-sm":b>=32&&128>b?"iconic-md":"iconic-lg";var h=a.getAttribute("class"),i=c.test(h)?h.replace(c,g):h+" "+g;a.setAttribute("class",i)}},h=function(){var a=document.querySelectorAll(".injected-svg.iconic-fluid");Array.prototype.forEach.call(a,function(a){g(a)})};document.addEventListener("DOMContentLoaded",function(){f()}),window.addEventListener("resize",function(){h()}),b.exports={refresh:g,refreshAll:h}},{}],8:[function(b,c,d){!function(b,e){"use strict";function f(a){a=a.split(" ");for(var b={},c=a.length,d=[];c--;)b.hasOwnProperty(a[c])||(b[a[c]]=1,d.unshift(a[c]));return d.join(" ")}var g="file:"===b.location.protocol,h=e.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure","1.1"),i=Array.prototype.forEach||function(a,b){if(void 0===this||null===this||"function"!=typeof a)throw new TypeError;var c,d=this.length>>>0;for(c=0;d>c;++c)c in this&&a.call(b,this[c],c,this)},j={},k=0,l=[],m=[],n={},o=function(a){return a.cloneNode(!0)},p=function(a,b){m[a]=m[a]||[],m[a].push(b)},q=function(a){for(var b=0,c=m[a].length;c>b;b++)!function(b){setTimeout(function(){m[a][b](o(j[a]))},0)}(b)},r=function(a,c){if(void 0!==j[a])j[a]instanceof SVGSVGElement?c(o(j[a])):p(a,c);else{if(!b.XMLHttpRequest)return c("Browser does not support XMLHttpRequest"),!1;j[a]={},p(a,c);var d=new XMLHttpRequest;d.onreadystatechange=function(){if(4===d.readyState){if(404===d.status||null===d.responseXML)return c("Unable to load SVG file: "+a),g&&c("Note: SVG injection ajax calls do not work locally without adjusting security setting in your browser. Or consider using a local webserver."),c(),!1;if(!(200===d.status||g&&0===d.status))return c("There was a problem injecting the SVG: "+d.status+" "+d.statusText),!1;if(d.responseXML instanceof Document)j[a]=d.responseXML.documentElement;else if(DOMParser&&DOMParser instanceof Function){var b;try{var e=new DOMParser;b=e.parseFromString(d.responseText,"text/xml")}catch(f){b=void 0}if(!b||b.getElementsByTagName("parsererror").length)return c("Unable to parse SVG file: "+a),!1;j[a]=b.documentElement}q(a)}},d.open("GET",a),d.overrideMimeType&&d.overrideMimeType("text/xml"),d.send()}},s=function(a,c,d,e){var g=a.getAttribute("data-src")||a.getAttribute("src");if(!/svg$/i.test(g))return e("Attempted to inject a file with a non-svg extension: "+g),void 0;if(!h){var j=a.getAttribute("data-fallback")||a.getAttribute("data-png");return j?(a.setAttribute("src",j),e(null)):d?(a.setAttribute("src",d+"/"+g.split("/").pop().replace(".svg",".png")),e(null)):e("This browser does not support SVG and no PNG fallback was defined."),void 0}-1===l.indexOf(a)&&(l.push(a),a.setAttribute("src",""),r(g,function(d){if("undefined"==typeof d||"string"==typeof d)return e(d),!1;var h=a.getAttribute("id");h&&d.setAttribute("id",h);var j=a.getAttribute("title");j&&d.setAttribute("title",j);var m=[].concat(d.getAttribute("class")||[],"injected-svg",a.getAttribute("class")||[]).join(" ");d.setAttribute("class",f(m));var o=a.getAttribute("style");o&&d.setAttribute("style",o);var p=[].filter.call(a.attributes,function(a){return/^data-\w[\w\-]*$/.test(a.name)});i.call(p,function(a){a.name&&a.value&&d.setAttribute(a.name,a.value)});for(var q,r=d.querySelectorAll("defs clipPath[id]"),s=0,t=r.length;t>s;s++){q=r[s].id+"-"+k;for(var u=d.querySelectorAll('[clip-path*="'+r[s].id+'"]'),v=0,w=u.length;w>v;v++)u[v].setAttribute("clip-path","url(#"+q+")");r[s].id=q}d.removeAttribute("xmlns:a");for(var x,y,z=d.querySelectorAll("script"),A=[],B=0,C=z.length;C>B;B++)y=z[B].getAttribute("type"),y&&"application/ecmascript"!==y&&"application/javascript"!==y||(x=z[B].innerText||z[B].textContent,A.push(x),d.removeChild(z[B]));if(A.length>0&&("always"===c||"once"===c&&!n[g])){for(var D=0,E=A.length;E>D;D++)new Function(A[D])(b);n[g]=!0}a.parentNode.replaceChild(d,a),delete l[l.indexOf(a)],a=null,k++,e(d)}))},t=function(a,b,c){b=b||{};var d=b.evalScripts||"always",e=b.pngFallback||!1,f=b.each;if(void 0!==a.length){var g=0;i.call(a,function(b){s(b,d,e,function(b){f&&"function"==typeof f&&f(b),c&&a.length===++g&&c(g)})})}else a?s(a,d,e,function(b){f&&"function"==typeof f&&f(b),c&&c(1),a=null}):c&&c(0)};"object"==typeof c&&"object"==typeof c.exports?c.exports=d=t:"function"==typeof a&&a.amd?a(function(){return t}):"object"==typeof b&&(b.SVGInjector=t)}(window,document)},{}]},{},[1])(1)});
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
