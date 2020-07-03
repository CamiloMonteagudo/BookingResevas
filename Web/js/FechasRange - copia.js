
var OneDay = (1000*60*60*24);
var pickerFrom;
var pickerTo;
var numberDays;
var fIni;
var fEnd;
var nDay;
  
$(function() 
  {
  pickerFrom = $("#from");
  pickerTo   = $("#to"  );
  numberDays = $("#dias");
  
  numberDays.keypress(function(e) {return OnChangeNDays(e);});
  numberDays.focusout(function()  {return ChangeNDays(0);});
  
  pickerFrom.datepicker(
    {
    showButtonPanel: false,
    changeMonth: false,
    changeYear: false,  
    dateFormat:"D dd M y",
    minDate: new Date(),
    onClose: ChangeFromDate
    });
  
  pickerTo.datepicker(
    {
    showButtonPanel: false,
    changeMonth: false,
    changeYear: false,  
    dateFormat:"D dd M y",
    minDate: new Date(),
    onClose: ChangeToDate
    });
  
  $(".num1").keypress( function(e) { return checkNum(e, 1); });
  $(".num2").keypress( function(e) { return checkNum(e, 2); });
  $(".num3").keypress( function(e) { return checkNum(e, 3); });
  });

function checkNum( e, tipo )
  {
  if( !((e.charCode>=48 && e.charCode<=57) || e.charCode==0  || e.charCode==46) )  
    return false;
    
  if( tipo==2 && e.charCode==48 && e.currentTarget.value.length==0 )
    return false;
    
  if( e.charCode==46 && tipo>1 )  return false;
  
  return true;  
  }
  
function ChangeFromDate()
  {
  CheckDates();
   
  var fEnd = new Date(fIni.getTime()+nDay*OneDay);
  var fMin = new Date(fIni.getTime()+OneDay);  
  
  pickerTo.datepicker( "option", "minDate", fMin );  
  pickerTo.datepicker( "setDate", fEnd );
  }

function ChangeToDate()
  {
  CheckDates();
  
  nDay = (fEnd.getTime() - fIni.getTime()) / OneDay;
  numberDays.val( Math.round(nDay) );
  }

function CheckDates()
  {
  fIni = pickerFrom.datepicker( "getDate" );
  fEnd = pickerTo.datepicker( "getDate" );
  nDay = numberDays.val();
  if( nDay<= 0 ) 
    {
    nDay = 1;
    numberDays.val( nDay );
    }
   
  if( !fIni  )
    {
    if( fEnd ) {fIni = new Date(fEnd.getTime()- nDay*OneDay);}
    else       {fIni = new Date();}

    pickerFrom.datepicker( "setDate", fIni );
    }
   
  if( !fEnd  )
    {
    fEnd = new Date(fIni.getTime()+nDay*OneDay);
    pickerTo.datepicker( "setDate", fEnd );
    }

  if( fEnd <= fIni )
    {
    fEnd = new Date(fIni.getTime()+nDay*OneDay);
    pickerTo.datepicker( "setDate", fEnd );
    }
  }

function OnChangeNDays(e)
  {
  if( !checkNum(e, 2) ) return false;
  var c = (e && e.charCode==0)? 0 : e.key;
  ChangeNDays( c );
  }
  
function ChangeNDays( c )
  {
  var nDay = numberDays.val();
  if( nDay<=0 )
    {
    if( c == 0 )
      {  
      nDay = 1;  
      numberDays.val(nDay);
      }
    else nDay = c;  
    }
   
  var fIni = pickerFrom.datepicker( "getDate" );
  if( !fIni )
    {
    fIni = new Date();
    pickerFrom.datepicker( "setDate", fIni );
    }
  
  var fEnd = new Date( fIni.getTime() + nDay * OneDay );
  pickerTo.datepicker( "setDate", fEnd );
  }
  
function FormatDate( fecha )
  {
  var Meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  var wDias = ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'];

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
  return  new Date( items[0], items[1], items[2] );  
  }
    
