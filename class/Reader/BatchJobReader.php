<?php

/**
 * Класс ридера заданий.
 */
class BatchJobReader implements BatchJobReaderInterface {

  /**
   * Загрузка задания.
   *
   * @inheritdoc.
   */
  public function read($id) {
    $data = $this->getJobData($id);

    if (!class_exists($data['context']['handler'])) {
      throw new \InvalidArgumentException(sprintf('Обработчик задания "%s" не определен', $data['context']['handler']));
    }

    // подготовка задания
    $job = new $data['context']['handler']($id);
    $job->setUid($data['uid']);
    $job->setTimestamp($data['timestamp']);
    $job->setStatus($data['status']);
    $job->setArguments($data['context']['arguments']);
    $job->setState($data['context']['state']);

    return $job;
  }

  /**
   * Загрузка данных из базы.
   *
   * @param string $id
   *   Идентификатор задания.
   *
   * @return array
   *   Контекст задания.
   */
  protected function getJobData($id) {
    // подготовка запроса
    $query = db_select('batch_job', 'j');
    $query->fields('j');
    $query->condition('id', $id);
    $data = $query->execute()->fetchAssoc();

    if (!$data) {
      throw new \InvalidArgumentException(sprintf('Задание #%s не найдено', $id));
    }

    $data['context'] = drupal_json_decode($data['context']);
    $data['context'] += array(
      'handler' => NULL,
      'arguments' => array(),
      'state' => array(),
    );

    return $data;
  }

}
