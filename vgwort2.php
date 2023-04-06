defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;

class plgContentVgwort extends CMSPlugin
{
  public function onContentPrepare($context, &$article, &$params, $page = 0)
  {
    // Only execute the plugin for the "com_content.article" context
    if ($context !== 'com_content.article') {
      return true;
    }

    // Prompt the user to insert a Zählmarke
    $prompt = JFactory::getApplication()->input->get('vgwort_prompt', false, 'bool');

    if ($prompt) {
      // Get the next available Zählmarke from the VGWORT portal
      $zaehlmarke = $this->getNextZaehlmarke();

      // Insert the Zählmarke into the article
      $article->text = str_replace('{zaehlmarke}', $zaehlmarke, $article->text);

      // Get the article URL and update the VGWORT table
      $url = Uri::getInstance()->toString();
      $this->updateVgwortTable($url);
    }

    return true;
  }

  private function getNextZaehlmarke()
  {
    // Connect to the VGWORT portal
    // You would need to implement this method yourself
    $vgwortPortal = new VGWORTPortal();

    // Get the next available Zählmarke
    $zaehlmarke = $vgwortPortal->getNextZaehlmarke();

    return $zaehlmarke;
  }

  private function updateVgwortTable($url)
  {
    // Connect to the VGWORT portal
    // You would need to implement this method yourself
    $vgwortPortal = new VGWORTPortal();

    // Update the VGWORT table with the article URL
    $vgwortPortal->updateTable($url);
  }
}
