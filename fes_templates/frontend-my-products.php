<?php
$user_id = get_current_user_id();
$concat  = get_option( 'permalink_structure') ? '?' : '&';
$user_id = get_current_user_id();

$pending_products = EDD_FES()->queries->get_pending_products( $user_id );

if ( ! empty( $pending_products ) ) :
?>
<h2><?php _e( 'Pending Review', 'lattice' ); ?></h2>

<table class="table my_account_orders table-condensed">
	<thead>
		<tr>
			<th><?php _e( 'Product', 'lattice' ); ?></th>
			<th><?php _e( 'Date/Time Submitted for Review', 'lattice' ); ?></th>
	</thead>
	<tbody>
		<?php foreach ( $pending_products as $product ) : ?>
			<tr>
				<td><?php echo esc_html( $product['title'] ); ?></td>
				<td><?php echo esc_html( $product['date'] ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php
endif;

$published_products = EDD_FES()->queries->get_published_products( $user_id );

if ( ! empty( $published_products ) ) :
?>
<h2><?php _e( 'Live Products', 'edd_fes' ); ?></h2>

<table class="table table-fancy my_account_orders table-condensed">
	<thead>
		<tr>
			<th><?php _e( 'Product', 'edd_fes' ); ?></th>
			<th><?php _e( 'Sales Quantity', 'edd_fes' ) ?></th>
			<th><?php _e( 'Actions','edd_fes') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sales = 0;
		$earnings = 0;

		foreach ( $published_products as $product ) : ?>
			<tr>
				<td><?php echo esc_html( $product['title'] ); ?></td>
				<td><?php echo esc_html( $product['sales'] ); ?></td>
				<td><a href="<?php echo esc_html( $product['url'] );?>" title="<?php _e( 'View', 'lattice' );?>" class="btn btn-mini view-product-fes"><?php _e( 'View', 'lattice' );?></a></td>
			</tr>
			<?php $sales += $product['sales']; ?>
		<?php endforeach; ?>
		<tr>
			<td><strong><?php _e( 'Total Sales', 'lattice' ); ?></strong></td>
			<td><?php echo $sales; ?></td>
			<td></td>
		</tr>
	</tbody>
</table>
<?php
endif;

if ( empty( $pending_products ) && empty( $published_products ) ) {
	_e( 'You have no products', 'lattice' );
}