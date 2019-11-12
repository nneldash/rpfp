/**
 * https://stackoverflow.com/questions/14521108/dynamically-load-js-inside-js
 * https://stackoverflow.com/questions/14644558/call-javascript-function-after-script-is-loaded
 * 
*/
var base_url = window.location.origin + '/rpfp/';

function isScriptLoaded(src, is_js = true)
{
    if (is_js) {
        return document.querySelector('script[src="' + src + '"]') ? true : false;
    }
    
    return document.querySelector('link[href="' + src + '"][rel="stylesheet"]') ? true : false;
}


function loadScript(script_file, callback = 'N/A', is_js = true)
{
    if (isScriptLoaded(script_file, is_js)) {
        if (callback != 'N/A') {
            callback();
        }
        return;
    }
    
    var element_type = 'script';
    var property_1 = 'src';
    var property_2 = 'no-tag';
    var value_2 = 'no-tag';
    if (!is_js) {
        element_type = 'link';
        property_1 = 'href';
        property_2 = 'rel';
        value_2 = 'stylesheet';
    }
    var script = document.createElement(element_type);
    script.async = false;
    script.onload = function () {
        if (callback != 'N/A') {
            callback();
        }        
    };

    script[property_1] = script_file;
    script[property_2] = value_2;
    document.getElementsByTagName( "head" )[0].appendChild( script );

    return true;
}

function loadJs(js_file, callback = 'N/A')
{
    loadScript(js_file, callback);
}

function loadCss(css_file, callback = 'N/A')
{
    loadScript(css_file, callback, false);
}
