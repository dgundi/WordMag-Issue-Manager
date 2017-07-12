<?php 

/**
* Class to initialise the WordMag WordPress Plugin
*
* @package WordMag Issue Manager
* @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
* @author Daniel Gundi
*/

class WordMag
{
	private $months;
	private $region;
	private $settingsarray;
	public $view_data;
	public $page;
	public $year_tab;
	
	public function __construct()
	{
		$settingsarray = [];
		if(isset($_GET["year"]))
        {
            $this->year_tab = $_GET["year"];
        } else {
        	$this->year_tab = date('Y');
        }
		$this->months = array(
			    array(
			            'id' => 'mag_cover_1',
			            'title' => 'January',
			        ),
			    array(
			            'id' => 'mag_cover_2',
			            'title' => 'February',
			        ),
			    array(
			            'id' => 'mag_cover_3',
			            'title' => 'March',
			        ),
			    array(
			            'id' => 'mag_cover_4',
			            'title' => 'April',
			        ),
			    array(
			            'id' => 'mag_cover_5',
			            'title' => 'May',
			        ),
			    array(
			            'id' => 'mag_cover_6',
			            'title' => 'June',
			        ),
			    array(
			            'id' => 'mag_cover_7',
			            'title' => 'July',
			        ),
			    array(
			            'id' => 'mag_cover_8',
			            'title' => 'August',
			        ),
			    array(
			            'id' => 'mag_cover_9',
			            'title' => 'September',
			        ),
			    array(
			            'id' => 'mag_cover_10',
			            'title' => 'October',
			        ),
			    array(
			            'id' => 'mag_cover_11',
			            'title' => 'November',
			        ),
			    array(
			            'id' => 'mag_cover_12',
			            'title' => 'December',
			        ),
		);

		add_action('admin_enqueue_scripts', array($this,'load_backend_resources'));
		add_action('admin_menu', array($this,'add_new_menu_items'));
		add_action("admin_init", array($this,'admin_init'));
	}

	public function load_backend_resources() {
		wp_enqueue_script('jquery-ui-draggable');
	    wp_enqueue_script('jquery-ui-droppable');
	    wp_enqueue_script('jquery-ui-sortable');
	    wp_enqueue_style('wmk-admin-styles',  plugin_dir_url(__FILE__) . 'static/css/admin-styles.css');
	    wp_enqueue_script('wmk-admin-scripts', plugin_dir_url(__FILE__) . 'static/js/admin-scripts.js', array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable'));
	    wp_enqueue_media ();
	    wp_enqueue_script('moment-js', plugin_dir_url(__FILE__) . 'static/js/moment.js', array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable'));
	}


	public function add_new_menu_items() {
		global $submenu;
		$capability = "manage_options";
	    add_menu_page("Featured Magazine Covers","Magazine Covers",$capability,"magazine-covers-featured", array($this,'display_magazinecovers_page'), "dashicons-admin-page", 1 );
	 //   add_submenu_page( "magazinecovers-options", "ANZ Magazine Covers", "ANZ", $capability, "anz-covers", array($this,'display_magazinecovers_page'));
	    add_submenu_page( "magazine-covers-featured", "ANZ Magazine Covers", "ANZ Covers", $capability, "magazine-covers-anz", array($this,'display_magazinecovers_page'));
	    add_submenu_page( "magazine-covers-featured", "Europe Magazine Covers", "Europe Covers", $capability, "magazine-covers-europe", array($this,'display_magazinecovers_page'));
	    add_submenu_page( "magazine-covers-featured", "Asia Magazine Covers", "Asia Covers", $capability, "magazine-covers-asia", array($this,'display_magazinecovers_page'));
	    add_submenu_page( "magazine-covers-featured", "India Magazine Covers", "India Covers", $capability, "magazine-covers-india", array($this,'display_magazinecovers_page'));
	    $submenu['magazine-covers-featured'][0][0] = 'Featured Covers';
	}

	public function admin_init() {
		for ($i=2013; $i <= date('Y'); $i++) { 
			add_settings_section($i."_featured_magazine_covers_section", "Featured Covers", $this->display_magazine_covers_header(), "magazine-covers-featured");
			add_settings_section($i."_anz_magazine_covers_section", "Australia Covers", $this->display_magazine_covers_header(), "magazine-covers-anz");
			add_settings_section($i."_asia_magazine_covers_section", "Asia Covers", $this->display_magazine_covers_header(), "magazine-covers-asia");
			add_settings_section($i."_europe_magazine_covers_section", "Europe Covers", $this->display_magazine_covers_header(), "magazine-covers-europe");
			add_settings_section($i."_india_magazine_covers_section", "India Covers", $this->display_magazine_covers_header(), "magazine-covers-india");
        	foreach ($this->months as $month) {
				register_setting($i."_featured_magazine_covers_section", $i.'_featured_'.$month['id']);
		        register_setting($i."_anz_magazine_covers_section", $i.'_anz_'.$month['id']);
		        register_setting($i."_europe_magazine_covers_section", $i.'_europe_'.$month['id']);
		        register_setting($i."_asia_magazine_covers_section", $i.'_asia_'.$month['id']);
		        register_setting($i."_india_magazine_covers_section", $i.'_india_'.$month['id']);
		    }
        }
		

	}

	public function display_magazine_covers_header() {

	}

	public function display_magazinecovers_page() {
		$settingsarray = $this->settingsarray;
		$this->page = $_GET['page'];

		switch ($this->page) {
			case 'magazine-covers-featured':
				$this->region = 'featured';
			break;
			case 'magazine-covers-anz':
				$this->region = 'anz';
			break;
			case 'magazine-covers-europe':
				$this->region = 'europe';
			break;
			case 'magazine-covers-asia':
				$this->region = 'asia';
			break;
			case 'magazine-covers-india':
				$this->region = 'india';
			break;
		}
		
	 	foreach ($this->months as $month) {
	    	$settingsarray[$month['title'].'_'.$this->year_tab] = $this->year_tab .'_'.$this->region. '_' . $month['id'];
	    }	

		$this->view('magazine-covers',$settingsarray);
	}

	public function view($name,$args) {
		$this->view_data = $args;
		$file = IW_WM_ROOT_PATH . '/views/' . $name . '.php';
		include($file);
	}
}