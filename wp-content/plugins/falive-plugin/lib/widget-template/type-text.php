<p>
	<label for="<?php echo esc_attr( $fieldid ); ?>"><?php echo esc_html( $title )  ?></label>
	<input class="widefat" id="<?php echo esc_attr( $fieldid ) ?>" name="<?php echo esc_attr( $fieldname ) ?>" type="text" value="<?php echo esc_attr( $value ) ?>" />
	<i><?php echo strip_tags( $desc, '<strong><b><em><u><i><br><p>' ) ?></i>
</p>