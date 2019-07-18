var baseURL  = 'http://darmaji-lab.xyz/desta-uas/index.php';

function loadTableRegister(){
	$('#isi-table').html('');
  $.ajax({
      type : 'post',
      url : baseURL,
      data : {fungsi:'select', table:'register'},
      dataType : 'json',
      success : function(response){
          if (response) {
            var a;
            for (var i = 0; i < response.length; i++) {
              a=1;
              a = a + i;
              $html = '<tr><td>'+a+'</td><td>'+response[i].NIM+'</td><td><label>'+response[i].nama+'</label><br>'+response[i].mata_kuliah+'<br>'+response[i].email+'<br>'+response[i].waktu+'</td></tr>';
              $('#isi-table').html($('#isi-table').html()+$html);
            }
          }
      }
  });
}

function loadTableLapor(){
  $('#isi-table').html('');
  $.ajax({
      type : 'post',
      url : baseURL,
      data : {fungsi:'select', table:'lapor'},
      dataType : 'json',
      success : function(response){
          if (response) {
            var a;
            for (var i = 0; i < response.length; i++) {
              a=1;
              a = a + i;
              $html = '<tr><td>'+a+'</td><td>'+response[i].NIM+'</td><td><label>'+response[i].nama+'</label><br>'+response[i].progdi+'<br>'+response[i].kelas+'<br>'+response[i].URL+'<br>'+response[i].kumpul+'</td></tr>';
              $('#isi-table').html($('#isi-table').html()+$html);
            }
          }
      }
  });
}

function simpanRegister(){
  var form = $('#form-register');
  var data = $(form).serialize();
  data = data+'&fungsi=insert&table=register';
  $.ajax({
    type : 'post',
    url : baseURL,
    data : data,
    dataType : 'json',
    success : function(response){
      if (response) {
        alert('Data Register tersimpan.'); 
      }
      else{
        alert('Data Register Gagal Disimpan');
      }
      location.href='./index.html';
    }
  })
}

function simpanLapor(){
  var form = $('#form-lapor');
  var data = $(form).serialize();
  data = data+'&fungsi=insert&table=lapor';

  console.log(data);
  $.ajax({
    type : 'post',
    url : baseURL,
    data : data,
    dataType : 'json',
    success : function(response){
      console.log(response);
      if (response) {
        alert('Data Lapor tersimpan.'); 
      }
      else{
        alert('Data Lapor Gagal Disimpan');
      }
      location.href='./index.html';
    }
  })
}

function onlyNumeric(char){
  var val = (char.which) ? char.which : event.keyCode
  if (val > 31 && (val < 48 || val > 57))
    return false;
  return true;
}