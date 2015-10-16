<?

namespace Concrete\Package\SampleContentGenerator\Controller\SinglePage\Dashboard;
use \Concrete\Core\Page\Controller\PageController;
use \Concrete\Core\Backup\ContentExporter;
use Loader;
class GenerateInstallData extends PageController {

	public function get_files() {
		$export = new ContentExporter();
		$filesLink = $export->getFilesArchive();
		$this->set('filesLink', REL_DIR_FILES_UPLOADED . '/tmp/' . $filesLink . '.zip');
	}

	public function get_content_xml() {
		$export = new ContentExporter();
		$export->run();
		// check packages
		$xml = $export->output();


		// Keep retrying as some empty nodes may contain other empty nodes
		while(true){
				$xml_ref = $xml; // keep old version as reference
				// Remove <node /> empty nodes
				$xml = preg_replace('~<[^\\s>]+\\s*/>~si', null, $xml);
				if($xml_ref === $xml) break;
		}
		$th = Loader::helper('text');
		$xml = $th->formatXML($xml);		
		$this->set('outputContent', $xml);
	}



}
