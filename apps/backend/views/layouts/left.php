<aside class="main-sidebar">

    <section class="sidebar">
    <?php if(!Yii::$app->user->isGuest){?>
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->request->baseUrl ?>/img/nophoto.png" class="img-circles" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=(!Yii::$app->user->isGuest ? Yii::$app->user->identity->name:'');?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('site/index') ?>">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php
        if(Yii::$app->user->identity->level === 'administrator'){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs text-maroon"></i>
            <span>Data Master</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu"> 
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('instansi') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Instansi</a></li> 
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('pejabat') ?>"><i class="fa fa-graduation-cap text-aqua"></i> Pejabat</a></li> 
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('golongan') ?>"><i class="fa fa-certificate text-yellow"></i> Golongan</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('jenisbarang') ?>"><i class="fa  fa-cube text-fuchsia"></i> Jenis Barang</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('kondisi') ?>"><i class="fa  fa-map-marker text-green"></i> Kondisi</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('jenisbbm') ?>"><i class="fa fa-power-off text-aqua"></i> Jenis BBM</a></li>            
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('merk') ?>"><i class="fa  fa-registered text-fuchsia"></i> Merk Kendaraan</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('type') ?>"><i class="fa  fa-car text-yellow"></i> Type Kendaraan</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('log') ?>"><i class="fa fa-sign-in text-red"></i> Log Akses</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('pemegang') ?>">
            <i class="fa  fa-graduation-cap text-aqua"></i>
            <span>Data Pemegang</span>
          </a>
        </li>        
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('kendaraan') ?>">
            <i class="fa  fa-car text-blue"></i>
            <span>Data Kendaraan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('histori') ?>">
            <i class="fa fa-book text-purple"></i>
            <span>Histori Kendaraan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('perawatan') ?>">
            <i class="fa  fa-cogs text-fuchsia"></i>
            <span>Data Perawatan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('pajak') ?>">
            <i class="fa  fa-cubes text-green"></i>
            <span>Pajak Kendaraan</span>
          </a>
        </li>
        <li>
          <a href="<?= Yii::$app->getUrlManager()->createUrl('user') ?>"><i class="fa fa-users text-yellow"></i> User Manager</a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs text-maroon"></i>
            <span>Laporan</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu"> 
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/all') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Kendaraan Dinas</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/kondisi') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Menurut Kondisi</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/perawatan') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Perawatan</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/bbm') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap BBM</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/pajak') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Pajak</a></li>
          </ul>
        </li>
        <?php
        }elseif(Yii::$app->user->identity->level === 'instansi'){
        ?>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('pemegang') ?>">
            <i class="fa  fa-graduation-cap text-aqua"></i>
            <span>Data Pemegang</span>
          </a>
        </li>        
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('kendaraan') ?>">
            <i class="fa  fa-car text-blue"></i>
            <span>Data Kendaraan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('histori') ?>">
            <i class="fa fa-book text-purple"></i>
            <span>Histori Kendaraan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('perawatan') ?>">
            <i class="fa  fa-cogs text-fuchsia"></i>
            <span>Data Perawatan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('pajak') ?>">
            <i class="fa  fa-cubes text-green"></i>
            <span>Pajak Kendaraan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs text-maroon"></i>
            <span>Laporan</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu"> 
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/all') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Kendaraan Dinas</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/kondisi') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Menurut Kondisi</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/perawatan') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Perawatan</a></li>
            <li><a href="<?= Yii::$app->getUrlManager()->createUrl('laporan/pajak') ?>"><i class="fa  fa-bookmark-o text-blue"></i> Rekap Pajak</a></li>
          </ul>
        </li> 
        <?php
        }elseif(Yii::$app->user->identity->level === 'pemegang'){
        ?>      
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('users/histori') ?>">
            <i class="fa  fa-car text-blue"></i>
            <span>Histori Kendaraan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('users/perawatan') ?>">
            <i class="fa  fa-cogs text-fuchsia"></i>
            <span>Data Perawatan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?= Yii::$app->getUrlManager()->createUrl('users/pajak') ?>">
            <i class="fa  fa-cubes text-green"></i>
            <span>Pajak Kendaraan</span>
          </a>
        </li>
        <?php
        }else{
        ?>
        <?php
        }
        ?>    
      </ul>
    <?php }?>
    </section>

</aside>