<div class="sidebar" data-color="blue">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="#" class="simple-text logo-mini">
      {{ ('GT') }}
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
      {{-- Setting management --}}
      @if(Auths::user("user.role") == 'adm')
      <li>
        <a data-toggle="collapse" href="#settingmanagement">
            <i class="now-ui-icons loader_gear"></i>
          <p>
            {{ ("Setting Management") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="settingmanagement">
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
      </li>
      @endif
      {{-- employe management --}}
      <li>
        <a data-toggle="collapse" href="#employeemanagement">
            <i class="now-ui-icons users_circle-08"></i>
          <p>
            {{ ("Employee Management") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="employeemanagement">
          <ul class="nav">
            <li class="@if ($activePage == 'profile') active @endif">
              <a href="{{ route('admin.pegawai.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Employee") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'users') active @endif">
              <a href="{{ route('user.index') }}">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p> {{ ("Master Data") }} </p>
              </a>
            </li>
          </ul>
        </div>
      </li>


      @if(Auths::user("user.role") == 'adm')
      {{-- Master data --}}
      <li>
        <a data-toggle="collapse" href="#datadisplay">
            <i class="now-ui-icons users_circle-08"></i>
          <p>
            {{ ("Master Data") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="datadisplay">
          <ul class="nav">
			<li>
				<a data-toggle="collapse" href="#dataPresence">
				<i class="now-ui-icons users_circle-08"></i>
				  <p>
					{{ ("Presence") }}
					<b class="caret"></b>
				  </p>
				</a>
				<div class="collapse" id="dataPresence">
				  <ul class="nav">
					<li class="@if ($activePage == 'presenceType') active @endif">
					  <a href="{{ route('admin.presence.type.index') }}">
						<i class="now-ui-icons shopping_credit-card"></i>
						<p> {{ ("Type") }} </p>
					  </a>
					</li>
					<li class="@if ($activePage == 'presenceVariant') active @endif">
					  <a href="{{ route('admin.presence.variant.index') }}">
						<i class="now-ui-icons shopping_credit-card"></i>
						<p> {{ ("Variant") }} </p>
					  </a>
					</li>
				  </ul>
				</div>
            </li>
            {{-- departemen --}}
            <li class="@if ($activePage == 'departemen') active @endif">
              <a href="{{ route('admin.departemen.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Departemen") }} </p>
              </a>
            </li>
            {{--  --}}
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
              <a href="{{ route('data.perusahaan_cabang') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Perusahaan Cabang") }} </p>
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
                <p> {{ ("Category") }} </p>
              </a>
            </li>
            {{--  --}}
            {{-- Tipeijin --}}
            <li class="@if ($activePage == 'TipeIjin') active @endif">
              <a href="{{ route('admin.TipeIjin.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Tipe ijin") }} </p>
              </a>
            </li>
            {{--  --}}
            {{-- country --}}
            <li class="@if ($activePage == 'country') active @endif">
              <a href="{{ route('admin.country.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Country") }} </p>
              </a>
            </li>
            {{--  --}}
             {{-- province --}}
            <li class="@if ($activePage == 'province') active @endif">
              <a href="{{ route('admin.province.index') }}">
                <i class="now-ui-icons shopping_credit-card"></i>
                <p> {{ ("Data Province") }} </p>
              </a>
            </li>
            {{--  --}}
            {{-- province --}}
          </ul>
        </div>
      </li>
      {{-- icons --}}
      <li class="@if ($activePage == 'icons') active @endif">
        <a href="{{ route('page.index','icons') }}">
          <i class="now-ui-icons education_atom"></i>
          <p>{{ ('Icons') }}</p>
        </a>
      </li>
      @endif
      <!-- <li class = "@if ($activePage == 'maps') active @endif">
        <a href="{{ route('page.index','maps') }}">
          <i class="now-ui-icons location_map-big"></i>
          <p>{{ ('Maps') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'notifications') active @endif">
        <a href="{{ route('page.index','notifications') }}">
          <i class="now-ui-icons ui-1_bell-53"></i>
          <p>{{ ('Notifications') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'table') active @endif">
        <a href="{{ route('page.index','table') }}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>{{ ('Table List') }}</p>
        </a>
      </li>
      <li class = "@if ($activePage == 'typography') active @endif">
        <a href="{{ route('page.index','typography') }}">
          <i class="now-ui-icons text_caps-small"></i>
          <p>{{ ('Typography') }}</p>
        </a>
      </li> -->
    </ul>
  </div>
</div>