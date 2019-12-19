<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script src="{{ asset('public/js/FCClientJS.js') }}"></script>
<script src="{{ asset('public/js/memberedit.js') }}"></script>

<img class="image1" src="http://attendance.teaq.co.id/assets/images/dewan/farhan.jpeg" />

<button onclick="face_detect(1,2)">Face Detect</button>
<span class="fd-td1" style="width:100px; height:100px; background:red;">ads</span>
<br>
<br>
<button onclick="tag_save(1,2)">Tag Save</button>
<span class="ts-td1"></span>
<br>
<br>
<button onclick="face_train(1,2)">Face Train</button>
<span class="ft-td1"></span>

<br>
<br>
<input type="text" class="nama_anggota" value="farhan"/>

<br>
<br>
<button onclick="face_recog(1,2)">Face Recog</button>