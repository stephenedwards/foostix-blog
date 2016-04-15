<p>
    <label for="<?php echo esc_attr( $fieldid ); ?>"><?php echo esc_html( $title )  ?></label>
	<textarea class="widefat" name="<?php echo esc_attr( $fieldname ) ?>" id="<?php echo esc_attr( $fieldid ) ?>"><?php echo esc_textarea( $value ) ?></textarea>
    <i><?php echo strip_tags( $desc, '<strong><b><em><u><i><br><p>' ) ?></i>
</p>