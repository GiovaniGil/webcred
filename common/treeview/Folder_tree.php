<?php
/*
 Folder Tree with PHP and jQuery.

 R. Savoul Pelister
 http://techlister.com

*/

class treeview {

	private $files;
	private $folder;
	
	function __construct( $path ) {
		
		$files = array();	
		
		if( file_exists( $path)) {
			if( $path[ strlen( $path ) - 1 ] ==  '/' )
				$this->folder = $path;
			else
				$this->folder = $path . '/';
			
			$this->dir = opendir( $path );
			while(( $file = readdir( $this->dir ) ) != false )
				$this->files[] = $file;
			closedir( $this->dir );
		}
	}

	function create_tree( ) {
			
		if( count( $this->files ) > 2 ) { /* First 2 entries are . and ..  -skip them */
			natcasesort( $this->files );
			$list = '<ul class="filetree" style="display: none;">';
			// Group folders first
			foreach( $this->files as $file ) {
				if( file_exists( $this->folder . $file ) && $file != '.' && $file != '..' && is_dir( $this->folder . $file )) {
					$list .= '<li class="folder collapsed"><a href="#" rel="' . htmlentities( $this->folder . $file ) . '/">' . htmlentities( $file ) . '</a></li>';
				}
			}
			// Group all files
			foreach( $this->files as $file ) {
				if( file_exists( $this->folder . $file ) && $file != '.' && $file != '..' && !is_dir( $this->folder . $file )) {
					$ext = preg_replace('/^.*\./', '', $file);
					$list .= '<li  class="file ext_' . $ext . '">					
						 <div class="row">
                			<div class="col-sm-6">
								<a href="file://///' . htmlentities( $this->folder . $file ) . '" rel="' . htmlentities( $this->folder . $file ) . '">' .
								substr(htmlentities( $file ),0,50) . (strlen(htmlentities( $file )) > 50 ? '...' : '') . '</a>
							</div>	
							<div class="col-sm-2 file">
								<a href="' . htmlentities( $this->folder . $file ) . '"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i> Remover</a>
							</div>
						</div>
					</li>';
				}
			}
			$list .= '</ul>';	
			return $list;
		}
	}
}

$path = urldecode( $_REQUEST['dir'] );
$tree = new treeview( $path );
echo $tree->create_tree();

?>