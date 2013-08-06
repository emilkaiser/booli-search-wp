<p>
	<label for="<?php echo $this->get_field_name('q'); ?>"><?php _e('Query'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('q'); ?>" name="<?php echo $this->get_field_name('q'); ?>" type="text" value="<?php echo esc_attr($instance['q']); ?>" />

	<label for="<?php echo $this->get_field_name('callerId'); ?>"><?php _e('CallerId'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('callerId'); ?>" name="<?php echo $this->get_field_name('callerId'); ?>" type="text" value="<?php echo esc_attr($instance['callerId']); ?>" />

	<label for="<?php echo $this->get_field_name('key'); ?>"><?php _e('Key'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('key'); ?>" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo esc_attr($instance['key']); ?>" />

	<label for="<?php echo $this->get_field_name('limit'); ?>"><?php _e('Limit'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($instance['limit']); ?>" />
</p>
