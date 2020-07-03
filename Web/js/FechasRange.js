//"use strict";

$(function() 
  {
  $(".num1").keypress( function(e) { return checkNum(e, 1); });
  $(".num2").keypress( function(e) { return checkNum(e, 2); });
  $(".num3").keypress( function(e) { return checkNum(e, 3); });

  $(".num1").focusout( function(e) { SetDefaultCero(e); });
  $(".num2").focusout( function(e) { SetDefaultUno(e); });
  $(".num3").focusout( function(e) { SetDefaultCero(e); });
  });

Date.OneDay = (1000*60*60*24);
Date.AddDays = function( fRef, nDay ){return new Date(fRef.getTime()+nDay*Date.OneDay);};
Date.DaysDif = function( f1, f2 ){return Math.round( (f1.getTime() - f2.getTime()) / Date.OneDay);};

function LinkDates( idFrom, idTo, idDias)
  {
  var elemFrom = $(idFrom);
  var elemTo   = $(idTo);
  var elemDays = $(idDias);
  
  var fIni, fEnd, nDay;
  
  IniDataPicker( elemFrom, ChangedFrom );
  IniDataPicker( elemTo  , ChangedTo   );
  
  elemDays.keypress(function(e) {return OnPressKey(e);});
  elemDays.focusout(function()  {OnFocusOut(); elemDays.val(nDay);});
    
  elemFrom.keypress(function() {return false;});
  elemTo.keypress(function() {return false;});
  
  function getFechaIni() { return elemFrom.datepicker( "getDate" );}
  function setFechaIni(f) { elemFrom.datepicker( "setDate", f );}
  
  function getFechaEnd() { return elemTo.datepicker( "getDate" );}
  function setFechaEnd(f) { elemTo.datepicker( "setDate", f );}
  
  function getNDias() { return (parseInt(elemDays.val()) || 1);}
  function setNDias(d) { elemDays.val(d);}
    
  this.GetFecha = function() { return FormatDbFecha( getFechaIni() );};
  
  this.IniDatos = function( fIni, Dias )
    { 
    setFechaIni( fIni );
    
    fEnd = Date.AddDays( fIni, Dias );
    setFechaEnd( fEnd );
    
    setNDias( Dias );
    
    var fMin = Date.AddDays( new Date(), 1 );
    if(fIni < fMin ) {fMin = fIni;}
    
    elemFrom.datepicker( "option", "minDate", fMin );  
    elemTo.datepicker( "option", "minDate", Date.AddDays( fIni, 1 ) );  
    };
  
  function ChangedFrom()
    {
    CheckDates();
     
    setFechaEnd( Date.AddDays(fIni,nDay) );
    elemTo.datepicker( "option", "minDate", Date.AddDays( fIni, 1 ) );  
    }

  function ChangedTo()
    {
    CheckDates();
    
    nDay = Date.DaysDif( fEnd, fIni);
    setNDias( nDay );
    }
  
  function CheckDates()
    {
    fIni = getFechaIni();
    fEnd = getFechaEnd();
    nDay = getNDias();
    if( nDay<= 0 ) 
      {
      nDay = 1;
      setNDias( nDay );
      }
     
    if( !fIni  )
      {
      if( fEnd ) {fIni = Date.AddDays( fEnd, -nDay);}
      else       {fIni = new Date();}
  
      setFechaIni( fIni );
      }
     
    if( !fEnd  )
      {
      fEnd = Date.AddDays( fIni, nDay );
      setFechaEnd( fEnd );
      }
  
    if( fEnd <= fIni )
      {
      fEnd = Date.AddDays( fIni, nDay );
      setFechaEnd( fEnd );
      }
    }
  
  function OnPressKey(e)
    {
    if( !checkNum(e, 2) ) {return false;}
    setTimeout(OnFocusOut, 250);
    }
    
  function OnFocusOut()
    {
    nDay = getNDias();
    fIni = getFechaIni();
    if( !fIni ) {setFechaIni( new Date() );}
    
    setFechaEnd( Date.AddDays( fIni, nDay ) );
    }
  }
 
function LinkDates2( idFromFecha, idFromDia, idToFecha, idToDia, idNDias)
  {
  var elemFromF = $(idFromFecha);
  var elemFromD = $(idFromDia);
  var elemToF   = $(idToFecha);
  var elemToD   = $(idToDia);
  var elemNDias = $(idNDias);
  
  var fFrom, fTo, dFrom, dTo, nDias;
  var fMin, fMax, dMin, dMax;
  
  IniDataPicker( elemFromF, ChangedFechaIni );
  IniDataPicker( elemToF  , ChangedFechaEnd   );
  
  elemFromF.keypress(function() {return false;});
  elemToF.keypress(function() {return false;});
  
  elemFromD.keypress(function(e) {return OnKeyDIni(e);});
  elemFromD.focusout(function()  {OnOutDIni(); setDiaIni(dFrom);});
  
  elemToD.keypress(function(e) {return OnKeyDFin(e);});
  elemToD.focusout(function()  {OnOutDFin(); setDiaEnd(dTo);});
    
  elemNDias.keypress(function(e) {return OnKeyNDias(e);});
  elemNDias.focusout(function()  {OnOutNDias(); setNDias(nDias);});
    
  function getFechaIni() { return elemFromF.datepicker( "getDate" );}
  function getFechaEnd() { return elemToF.datepicker( "getDate" );}
  function setFechaIni(f) { elemFromF.datepicker( "setDate", f );}
  function setFechaEnd(f) { elemToF.datepicker( "setDate", f );}

  function getDiaIni() { return (parseInt(elemFromD.val()) || 0);}
  function getDiaEnd() { return (parseInt(elemToD.val()) || 1);}
  function setDiaIni(d) { elemFromD.val(d);}
  function setDiaEnd(d) { elemToD.val(d);}
  
  function getNDias() { return (parseInt(elemNDias.val()) || 1);}
  function setNDias(d) { elemNDias.val(d);}
    
  this.getFechaIni = function() { return FormatDbFecha( getFechaIni() );};
  this.getFechaEnd = function() { return FormatDbFecha( getFechaEnd() );};
  
  this.getDiaIni = getDiaIni;
  this.getDiaEnd = getDiaEnd;
    
  this.IniDatos = function( fEnt, Dias, dIni, dEnd )
    { 
    fMin = FechaFromStr( fEnt );
    fMax = Date.AddDays( fMin, Dias );
    
    dMin = 0;
    dMax = Dias;
    nDias = dEnd-dIni;

    setFechaIni( Date.AddDays( fMin, dIni) );
    setFechaEnd( Date.AddDays( fMin, dEnd) );
    
    elemFromF.datepicker( "option", "maxDate", Date.AddDays( fMax, -1 ) );  
    elemFromF.datepicker( "option", "minDate", fMin );  
    
    elemToF.datepicker( "option", "maxDate", fMax );  
    elemToF.datepicker( "option", "minDate", Date.AddDays( fMin, 1 ) );  
    
    setDiaIni(dIni);
    setDiaEnd(dEnd);
    setNDias(nDias);
    };
  
  function ChangedFechaIni()
    {
    fFrom = getFechaIni();
    dFrom = Date.DaysDif( fFrom, fMin );
    nDias = getNDias();
    
    if( dFrom + nDias > dMax ) 
       {nDias = dMax - dFrom;}

    elemToF.datepicker( "option", "minDate", Date.AddDays(fFrom,1) );  
    
    setDiaIni(dFrom);
    
    fTo = Date.AddDays(fFrom, nDias);
    setFechaEnd(fTo);
    
    dTo = dFrom + nDias;
    setDiaEnd(dTo);
    
    setNDias(nDias);
    }

  function ChangedFechaEnd()
    {
    fFrom = getFechaIni();
    fTo = getFechaEnd();
    dFrom = getDiaIni();
    
    nDias = Date.DaysDif( fTo, fFrom );
    
    dTo = dFrom + nDias;
    setDiaEnd(dTo);
    
    setNDias(nDias);
    }
  
  function OnKeyDIni(e)
    {
    if( !checkNum(e, 3) ) {return false;}
    setTimeout(OnOutDIni, 250);
    }
    
  function OnOutDIni()
    {
    dFrom = getDiaIni();
    if( dFrom >= dMax ) { dFrom=dMax-1;}
    
    nDias = getNDias();
    
    if( dFrom + nDias > dMax ) 
       {nDias = dMax - dFrom;}
    
    fFrom = Date.AddDays( fMin, dFrom );
    setFechaIni(fFrom);
    
    fTo = Date.AddDays(fFrom, nDias);
    setFechaEnd(fTo);
    
    dTo = dFrom + nDias;
    setDiaEnd(dTo);
    
    setNDias(nDias);

    elemToF.datepicker( "option", "minDate", Date.AddDays(fFrom,1) );  
    }
  
  function OnKeyDFin(e)
    {
    if( !checkNum(e, 2) ) {return false;}
    setTimeout(OnOutDFin, 250);
    }
    
  function OnOutDFin()
    {
    dTo = getDiaEnd();
    dFrom = getDiaIni();
    
    if( dTo<dFrom )  {dTo = dFrom+1;}
    if( dTo-dFrom > dMax ) {dTo = dMax - dFrom;}
     
    nDias = dTo - dFrom;
    fFrom = getFechaIni();
    fTo = Date.AddDays(fFrom, nDias);
    setFechaEnd(fTo);
    
    setNDias(nDias);
    }
    
  function OnKeyNDias(e)
    {
    if( !checkNum(e, 2) ) {return false;}
    setTimeout(OnOutNDias, 250);
    }
    
  function OnOutNDias()
    {
    nDias = getNDias();
    
    dFrom = getDiaIni();
    if( dFrom + nDias > dMax ) 
       {nDias = dMax - dFrom;}
    
    fFrom = Date.AddDays( fMin, dFrom );
    
    fTo = Date.AddDays(fFrom, nDias);
    setFechaEnd(fTo);
    
    dTo = dFrom + nDias;
    setDiaEnd(dTo);
    }
  }
 
function LinkDates3( idFrom, idTo)
  {
  var elemFrom = $(idFrom);
  var elemTo   = $(idTo);
  
  var fIni, fEnd;
  
  IniDataPicker( elemFrom, ChangedFrom );
  IniDataPicker( elemTo  , ChangedTo   );
  
  elemFrom.keypress(function() {return false;});
  elemTo.keypress(function() {return false;});
  
  function getFechaIni() { return elemFrom.datepicker( "getDate" );}
  function setFechaIni(f) { elemFrom.datepicker( "setDate", f );}
  
  function getFechaEnd() { return elemTo.datepicker( "getDate" );}
  function setFechaEnd(f) { elemTo.datepicker( "setDate", f );}
    
  this.GetFechaIni = function() { return FormatDbFecha( getFechaIni() );};
  this.GetFechaEnd = function() { return FormatDbFecha( getFechaEnd() );};
  
  this.IniDatos = function( fIni, fEnd )
    { 
    setFechaIni( fIni );
    setFechaEnd( fEnd );
    
    elemFrom.datepicker( "option", "minDate", Date.AddDays( new Date(), 1 ) );  
    elemTo.datepicker( "option", "minDate", Date.AddDays( fIni, 1 ) );  
    };
  
  function ChangedFrom()
    {
    fIni = getFechaIni();
    fEnd = getFechaEnd();
    
    var FMin =  Date.AddDays( fIni, 1 );
    if( fEnd < FMin ) {setFechaEnd( FMin );}
    
    elemTo.datepicker( "option", "minDate", FMin );  
    }

  function ChangedTo()
    {
    }
  }
 
function IniDataPicker( elem, funClose )
  {
  elem.datepicker(
    {
    showButtonPanel: false,
    changeMonth: false,
    changeYear: false,  
    dateFormat:"D dd M y",
    onClose: funClose
    });
  }
  
function checkNum( e, tipo )
  {
  if( !((e.charCode>=48 && e.charCode<=57) || e.charCode==0  || e.charCode==46) )  
    {return false;}
    
  if( tipo==2 && e.charCode==48 && e.currentTarget.value.length==0 )
    {return false;}
    
  if( e.charCode==46 && tipo>1 ) {return false;}
  
  return true;  
  }
  
function SetDefaultCero( e )
  {
  var val = e.currentTarget.value;
  
  if( val.length==0 || parseInt(val)==0 )
    {e.currentTarget.value = 0;}
  }
  
function SetDefaultUno( e )
  {
  var elem = e.currentTarget;
  var val = parseInt(elem.value); 

  if( val==0 || isNaN(val) )   
    elem.value = 1; 
  }
  
var Meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
var wDias = ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'];
  
function FormatDate( fecha )
  {
  var dia  = fecha.getDate();
  var wdia = fecha.getDay();
  var mes  = fecha.getMonth();
  var ano  = fecha.getYear() + 1900 - 2000;
  
  return  wDias[wdia] + ' ' + dia + ' ' + Meses[mes] + ' ' + ano;  
  }
    
function FormatDbFecha( fecha )
  {
  var dia  = fecha.getDate();
  var mes  = fecha.getMonth()+1;
  var ano  = fecha.getYear() + 1900;
  
  return  ano + '-' + mes + '-' + dia;  
  }
    
function FechaFromStr( sfecha )
  {
  var items = sfecha.split("-");  
  return  new Date( items[0], items[1]-1, items[2] );  
  }
    
var Meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  
function DiaMes( sfecha )
  {
  var fecha = new Date(sfecha);  
  
  var dia  = fecha.getDate();
  var mes  = fecha.getMonth();
  
  return  dia + ' ' + Meses[mes];  
  }
