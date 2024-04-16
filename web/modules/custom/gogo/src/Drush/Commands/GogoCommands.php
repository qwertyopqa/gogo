<?php

namespace Drupal\gogo\Drush\Commands;

use Drush\Commands\DrushCommands;
use Drupal\taxonomy\Entity\Term;

/**
 * A Drush commandfile.
 */
final class GogoCommands extends DrushCommands {

  /**
   * A drush command to import countries into the country taxonomy.
   *
   * @command gogo:import-countries
   * @aliases ggic
   */
  public function importCountries() {
    $vid = 'country';
    $vocabulary = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_vocabulary')
      ->load($vid);
    if (empty($vocabulary)) {
      $this->output()->writeln('Vocabulary "' . $vid . '" not found');
      return;
    }
    $data = file_get_contents('http://country.io/names.json');
    if ($data === FALSE) {
      $this->output()->writeln('Could not fetch data from the API');
      return;
    }
    $terms =\Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid);
    $existing_terms = [];
    foreach ($terms as $term) {
      $existing_terms[] = $term->name;
    }
    $data = json_decode($data, TRUE);
    $imported = 0;
    $skipped = 0;
    foreach ($data as $key => $name) {
      if (in_array($name, $existing_terms)) {
        $skipped++;
        continue;
      }
      $term = Term::create([
        'name' => $name,
        'vid' => $vid,
      ]);
      $term->save();
      $imported++;
    }
    $this->output()->writeln(
      'Imported: ' . $imported .
      ' || Skipped: ' . $skipped .
      ' :: Thank you for using GoGo!'
    );
  }

}
