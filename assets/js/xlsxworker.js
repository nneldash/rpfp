/* xlsx.js (C) 2013-present SheetJS -- http://sheetjs.com */
importScripts('../../node_modules/xlsx/dist/shim.min.js');
/* uncomment the next line for encoding support */
importScripts('../../node_modules/xlsx/dist/cpexcel.js');
importScripts('../../node_modules/xlsx/jszip.js');
importScripts('../../node_modules/xlsx/xlsx.js');
postMessage({t:"ready"});

onmessage = function (evt) {
  var v;
  try {
    v = XLSX.read(evt.data.d, {type: evt.data.b});
postMessage({t:"xlsx", d:JSON.stringify(v)});
  } catch(e) { postMessage({t:"e",d:e.stack||e}); }
};
