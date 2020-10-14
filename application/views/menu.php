<?php if($this->session->userdata('userdata')) { ?>
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?=base_url('buku')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Buku
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=base_url('jenisbuku')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Jenis Buku
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=base_url('pelanggan')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Pelanggan
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=base_url('peminjaman/create')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Peminjaman Buku
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=base_url('tracking/index')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Tracking Buku
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=base_url('trackingpeminjaman/index')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Tracking Peminjaman
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=base_url('cabang/index')?>" class="nav-link">
        <i class="nav-icon far fa-image"></i>
        <p>
          Ganti Cabang
        </p>
      </a>
    </li>
  </ul>
</nav>

<?php } ?>