<div class="sidebar" data-color="blue">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="#" class="simple-text logo-mini">
      <img src="{{ asset(''.'assets') }}/img/favicon.png">
    </a>
    <a href="#" class="simple-text logo-normal">
      {{ Auths::user("user.name") }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="@if ($activePage == 'dashboard') active @endif">
        <a href="{{ route('dashboard') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ ('Dashboard') }}</p>
        </a>
      </li> 
      <li class="@if ($activePage == 'announcement') active @endif">
        <a href="{{ route('admin.announcement.index') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ ('Announcement') }}</p>
        </a>
      </li> 
      <li>
        <a data-toggle="collapse" href="#agenda">
            <i class="now-ui-icons loader_gear"></i>
          <p>
            {{ ("Agenda") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="agenda">
          <ul class="nav">
            <li class="@if ($activePage == 'TipeAgenda') active @endif">
              <a href="{{ route('admin.TipeAgenda.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Tipe Agenda") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'agenda') active @endif">
              <a href="{{ (Auths::user('user.role')=='adm')? route('admin.agenda.index') :route('employee.agenda.index') }}">
                <i class="now-ui-icons design_app"></i>
                <p>{{ ('Data Agenda') }}</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <a data-toggle="collapse" href="#spj">
            <i class="now-ui-icons loader_gear"></i>
          <p>
            {{ ("SPJ") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="spj">
          <ul class="nav">
            <li class="@if ($activePage == 'st') active @endif">
              <a href="{{ route('admin.st.index') }}">
                <i class="now-ui-icons design_app"></i>
                <p>{{ ('Surat Tugas') }}</p>
              </a>
            </li>
            <li class="@if ($activePage == 'sp2d') active @endif">
              <a href="{{ route('admin.sp2d.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("SP2D") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'SPJ') active @endif">
              <a href="{{ route('admin.spj.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("SPJ") }} </p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <a data-toggle="collapse" href="#schedule">
            <i class="now-ui-icons loader_gear"></i>
          <p>
            {{ ("Schedule") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="schedule">
          <ul class="nav">
            <li class="@if ($activePage == 'schedule') active @endif">
              <a href="{{ route('admin.schedule.index') }}">
                <i class="now-ui-icons design_app"></i>
                <p>{{ ('Schedule') }}</p>
              </a>
            </li>
            <li class="@if ($activePage == 'presenceType') active @endif">
              <a href="{{ route('admin.presence.type.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Tipe Presensi") }} </p>
              </a>
            </li>
			<!--
            <li class="@if ($activePage == 'presence') active @endif">
              <a href="{{ route('employee.presence.index') }}">
                <i class="now-ui-icons design_app"></i>
                <p>{{ ('Presence') }}</p>
              </a>
            </li>
			-->
          </ul>
        </div>
      </li>
     <!--  {{-- Employee Management --}}
      <li>
        <a data-toggle="collapse" href="#employeemanagement">
            <i class="now-ui-icons loader_gear"></i>
          <p>
            {{ ("Employee Management") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="settingmanagement">
          <ul class="nav">
            <li class="@if ($activePage == 'profile') active @endif">
              <a href="{{ route('profile.edit') }}"> 
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ ("User Profile") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'users') active @endif">
              <a href="{{ route('user.index') }}">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p> {{ ("User Management") }} </p>
              </a>
            </li>
          </ul>
        </div>
      </li> -->
      {{-- employe management --}}
      <li>
        <a data-toggle="collapse" href="#employeemanagement">
            <i class="now-ui-icons users_circle-08"></i>
          <p>
            {{ ("Employee Management") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="employeemanagement">
          <ul class="nav">
            <li class="@if ($activePage == 'profile') active @endif">
              <a href="{{ route('admin.employee.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Employee") }} </p>
              </a>
            </li>
            {{-- departemen --}}
            <li class="@if ($activePage == 'departemen') active @endif">
              <a href="{{ route('admin.departemen.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Departemen") }} </p>
              </a>
            </li>
            {{--  --}}
            {{-- jabatan --}}
            <li class="@if ($activePage == 'jabatan') active @endif">
              <a href="{{ route('admin.jabatan.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data jabatan") }} </p>
              </a>
            </li>
            {{--  --}}
            {{-- category --}}
            <li class="@if ($activePage == 'category') active @endif">
              <a href="{{ route('admin.category.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Golongan") }} </p>
              </a>
            </li>
            {{--  --}}
          </ul>
        </div>
      </li>

      {{-- Company Management --}}
      <li>
        <a data-toggle="collapse" href="#companymanagement">
            <i class="now-ui-icons loader_gear"></i>
          <p>
            {{ ("Company Management") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="companymanagement">
          <ul class="nav">
            {{-- perusahaan --}}
            <li class="@if ($activePage == 'perusahaan') active @endif">
              <a href="{{ route('admin.perusahaan.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Perusahaan") }} </p>
              </a>
            </li>
            {{--  --}}
            {{-- perusahaan cabang --}}
            <li class="@if ($activePage == 'perusahaan_cabang') active @endif">
              <a href="{{ route('admin.perusahaan_cabang.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Perusahaan Cabang") }} </p>
              </a>
            </li>
            {{--  --}}
          </ul>
        </div>
      </li>


      {{-- Master data --}}
      <li>
        <a data-toggle="collapse" href="#datadisplay">
            <i class="now-ui-icons users_circle-08"></i>
          <p>
            {{ ("Master Data") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse submenu" id="datadisplay">
          <ul class="nav">
            <li class="@if ($activePage == 'country') active @endif">
              <a href="{{ route('admin.country.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Country") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'province') active @endif">
              <a href="{{ route('admin.province.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Province") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'city') active @endif">
              <a href="{{ route('admin.city.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data City") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'calendar') active @endif">
              <a href="{{ route('admin.calendar.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Calendar") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'user') active @endif">
              <a href="{{ route('admin.user.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data User") }} </p>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>