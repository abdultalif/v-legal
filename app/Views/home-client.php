<div class="row">
	<div class="col-md-12 mb-3">
		<div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
            Yth. Bapak/Ibu Eksportir.<br/>
            Dikarenakan semakin banyaknya <b>Data Produk</b> yang telah masuk di sistem kami, maka kami akan menghilangkan beberapa produk yang sudah ada dari website V-Legal yang sebelumnya. Jika Bapak/Ibu telah mengisi produk pada data master di web yang baru ini, data tersebut tidak akan hilang. Jika ternyata produknya hilang, Bapak/Ibu dapat menginputnya kembali pada menu Data Master.<br/>
            Demikian informasi yang dapat kami sampaikan, mohon maaf atas ketidaknyamanannya.
		</div>
		<div class="card card-outline card-<?=env('theme.color');?>">
			<div class="card-header">
		        <span class="card-title">
		        	<i class="fa fa-fw fa-question-circle"></i> 
		        	Download Manual Penggunaan Aplikasi
		        </span>
			</div>
        	<ul class="list-group list-group-flush">
        		<li class="list-group-item py-1">
        			<a target="_blank" target="blank" href="https://sarbisertifikasi.com/wp-content/uploads/2022/01/Prosedur-Penerbitan-V-Legal-PT-SIC-2022.pdf" class="text-dark">
        				<i class="fa fa-fw fa-file-pdf text-danger"></i>
        				Prosedur Penerbitan Dokumen V-Legal 2022
        			</a>
        		</li>
        		<li class="list-group-item py-1">
        			<a target="_blank" href="https://sarbisertifikasi.com/wp-content/uploads/2022/01/List-HS-Code.pdf" class="text-dark">
        				<i class="fa fa-fw fa-file-excel text-success"></i>
        				List HS Code
					</a>
        		</li>
        		<li class="list-group-item py-1">
        			<a target="_blank" href="https://sarbisertifikasi.com/wp-content/uploads/2022/01/Pelabuhan-Muat-Loading.pdf" class="text-dark">
        				<i class="fa fa-fw fa-file-excel text-success"></i>
        				List Pelabuhan Muat (Port of Loading)
					</a>
        		</li>
        		<li class="list-group-item py-1">
        			<a target="_blank" href="https://sarbisertifikasi.com/wp-content/uploads/2022/01/Pelabuhan-Bongkar-Discharge.pdf" class="text-dark">
        				<i class="fa fa-fw fa-file-excel text-success"></i>
        				List Pelabuhan Bongkar (Port of Discharge)
					</a>
        		</li>
        		<li class="list-group-item py-1">
        			<a target="_blank" target="blank" href="https://sarbisertifikasi.com/wp-content/uploads/2022/01/FM.VLK-SIC-018-Aplikasi-Permohonan-Dok-V-legal-2018-1-1.doc" class="text-dark">
        				<i class="fa fa-fw fa-file-word text-primary"></i>
        				Format Form Permohonan V-Legal
        			</a>
        		</li>
        		<li class="list-group-item py-1">
        			<a target="_blank" href="https://sarbisertifikasi.com/wp-content/uploads/2022/01/Format-Surat-Pembatalan.docx" class="text-dark">
        				<i class="fa fa-fw fa-file-word text-primary"></i>
        				Format Surat Pembatalan
					</a>
        		</li>
        	</ul>
        </div>
	</div>
	<div class="col-md-4 mb-3">
		<div class="card card-widget widget-user">
		  <!-- Add the bg color to the header using any of the bg-* classes -->
		  <div class="widget-user-header bg-<?=env('theme.color');?>">
			<h3 class="widget-user-username text-uppercase">
			  <?= userdata('name'); ?>
			</h3>
			<span class="widget-user-desc text-uppercase font-weight-normal">
			  <?php if (clientdata(userdata('user_id'))): ?>
			  <?= $client['no_sertifikat']; ?>
			  <?php else: ?>
			  <?= userdata('role'); ?>
			  <?php endif; ?>
			</span>
		  </div>
		  <div class="widget-user-image">
			<img class="img-circle elevation-2 bg-white" style="min-height: 80px;" src="<?= base_url(); ?>/img/user/<?= userdata('foto'); ?>" alt="User Avatar">
		  </div>
		  <div class="card-footer">
			<div class="row">
			  <div class="col-sm-12">
				<div class="description-block">
				  <span class="description-text">Joined Since
				  </span>
				  <h5 class="description-header">
					<?= format_tanggal(userdata('created_at'), 'F Y'); ?>
				  </h5>
				</div>
				<a href="<?= base_url('profile'); ?>" class="btn btn-block bg-<?=env('theme.color');?>">
				  <i class="fa fa-edit">
				  </i>
				  Ganti Password
				</a>
				<!-- /.description-block -->
			  </div>
			  <!-- /.col -->
			</div>
			<!-- /.row -->
		  </div>
		</div>
	</div>
	<div class="col-md-8 mb-3">
		<div class="card-deck mb-3">
			<div class="card card-outline card-<?=env('theme.color');?>">
				<div class="card-header">
				  <h5 class="card-title">
					<svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					  <path stroke="none" d="M0 0h24v24H0z" fill="none">
					  </path>
					  <circle cx="12" cy="7" r="4">
					  </circle>
					  <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2">
					  </path>
					</svg>
					Data Eksportir
				  </h5>
				  <div class="card-tools">
					<a href="<?= base_url(); ?>/client" class="btn btn-xs btn-secondary">
					  Check
					  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none">
						</path>
						<line x1="5" y1="12" x2="19" y2="12">
						</line>
						<line x1="13" y1="18" x2="19" y2="12">
						</line>
						<line x1="13" y1="6" x2="19" y2="12">
						</line>
					  </svg>
					</a>
				  </div>
				</div>
				<div class="card-body py-2">
				  <p class="card-text">
					Data eksportir wajib diisi untuk digunakan untuk mengajukan penerbitan vlegal
				  </p>
				</div>
			</div>
			<div class="card card-outline card-<?=env('theme.color');?>">
			<div class="card-header">
			  <h5 class="card-title">
				<svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
				  <path stroke="none" d="M0 0h24v24H0z" fill="none">
				  </path>
				  <path d="M14 3v4a1 1 0 0 0 1 1h4">
				  </path>
				  <path d="M5 13v-8a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5.5m-9.5 -2h7m-3 -3l3 3l-3 3">
				  </path>
				</svg>
				Upload LMK
			  </h5>
			  <div class="card-tools">
				<a href="<?= base_url(); ?>/lampiran" class="btn btn-xs btn-secondary">
				  Check
				  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none">
					</path>
					<line x1="5" y1="12" x2="19" y2="12">
					</line>
					<line x1="13" y1="18" x2="19" y2="12">
					</line>
					<line x1="13" y1="6" x2="19" y2="12">
					</line>
				  </svg>
				</a>
			  </div>
			</div>
			<div class="card-body py-2">
			  <p class="card-text">
				Eksportir wajib untuk melakukan upload LMK setiap bulan
			  </p>
			</div>
			</div>
		</div>
		<div class="card-deck mb-3">
		  <div class="card card-outline card-<?=env('theme.color');?>">
			<div class="card-header">
			  <h5 class="card-title">
				<svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
				  <path stroke="none" d="M0 0h24v24H0z" fill="none">
				  </path>
				  <path d="M14 3v4a1 1 0 0 0 1 1h4">
				  </path>
				  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
				  </path>
				  <line x1="9" y1="7" x2="10" y2="7">
				  </line>
				  <line x1="9" y1="13" x2="15" y2="13">
				  </line>
				  <line x1="13" y1="17" x2="15" y2="17">
				  </line>
				</svg>
				Data Pengajuan
			  </h5>
			  <div class="card-tools">
				<a href="<?= base_url(); ?>/pengajuan" class="btn btn-xs btn-secondary">
				  Check
				  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none">
					</path>
					<line x1="5" y1="12" x2="19" y2="12">
					</line>
					<line x1="13" y1="18" x2="19" y2="12">
					</line>
					<line x1="13" y1="6" x2="19" y2="12">
					</line>
				  </svg>
				</a>
			  </div>
			</div>
			<div class="card-body py-2">
			  <p class="card-text">
				Isi form permohonan dan upload lampiran permohonan untuk menerbitkan dokumen vlegal
			  </p>
			</div>
		  </div>
		  <div class="card card-outline card-<?=env('theme.color');?>">
			<div class="card-header">
			  <h5 class="card-title">
				<svg xmlns="http://www.w3.org/2000/svg" class="nav-icon icon-tabler icon-tabler-file-alert" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
				  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
				  <path d="M14 3v4a1 1 0 0 0 1 1h4" />
				  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
				  <line x1="12" y1="17" x2="12.01" y2="17" />
				  <line x1="12" y1="11" x2="12" y2="14" />
				</svg>
				Cek Status Dokumen
			  </h5>
			  <div class="card-tools">
				<a href="<?= base_url(); ?>/vlegal" class="btn btn-xs btn-secondary">
				  Check
				  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none">
					</path>
					<line x1="5" y1="12" x2="19" y2="12">
					</line>
					<line x1="13" y1="18" x2="19" y2="12">
					</line>
					<line x1="13" y1="6" x2="19" y2="12">
					</line>
				  </svg>
				</a>
			  </div>
			</div>
			<div class="card-body py-2">
			  <p class="card-text">
				Eksportir bisa melakukan cek status dokumen vlegal yang sudah terintegrasi langsung dengan LIU.
			  </p>
			</div>
		  </div>
		</div>
	</div>
</div>