<?php
class block_simplehtml extends block_base {
    public function init() {
        $this->title = get_string('simplehtml', 'block_simplehtml');
		//$this->text = get_string('simplehtml', 'block_simplehtml');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
	public function get_content() {
		if ($this->content !== null) {
		    $tmp = $this->title;
		    $this->instance_config_save($this->content);
		    $this->title = $tmp;
		    return $this->content;
		}
	 
		$this->content         =  new stdClass;
		$this->content->text   = 'The content of our SimpleHTML block!';
		global $COURSE;
		// The other code.
		$url = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
		$this->content->footer = html_writer::link($url, get_string('addpage', 'block_simplehtml'));
	 
		return $this->content;
	}

    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_simplehtml');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->content->text = get_string('defaulttext', 'block_simplehtml');
			}
			else {
                $this->content->text = $this->config->text;
            }
        }
    }
	
	public function instance_allow_multiple() {
		return true;
	}
	
	public function html_attributes() {
		$attributes = parent::html_attributes(); // Get default values
		$attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute
		return $attributes;
	}
	
	function has_config() {return true;}
	
	public function hide_header() { return true;}
	
	public function instance_config_save($data,$nolongerused =false) {
		if(get_config('simplehtml', 'Allow_HTML') == '1') {
			$data->text = strip_tags($data->text);
		}
 
		// And now forward to the default implementation defined in the parent class
		return parent::instance_config_save($data,$nolongerused);
	}
	
}
?>