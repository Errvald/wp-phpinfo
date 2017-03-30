<div class="wrap">
    <h1 class="page-title"><?php echo $this->pageMeta['name'];?></h1>

    <div class="phinfo-table">
    <?php
		foreach( $tests as $test ) {
			echo '<div class="phinfo-table__item">';
            echo '  <div class="phinfo-table__status">';
            if ( $test['status'] == 'OK' ) {
				echo '<span class="dashicons dashicons-yes dashicons--ok"></span>';
			} elseif ( $test['status'] == 'FAIL') {
				echo '<span class="dashicons dashicons-no-alt dashicons--fail"></span>';
			} elseif ( $test['status'] == 'WARNING') {
				echo '<span class="dashicons dashicons-warning dashicons--warning"></span>';
			}
            echo '  </div>';

			echo '	<div class="phinfo-table__name">';
            echo '    '.$test['title'];
			echo '	  <div class="phinfo-table__desc">' . $test['value'] . '</div>';
			echo '	</div>';

			echo '</div>';
		}
		?>
    </div>
</div>