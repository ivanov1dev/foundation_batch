<?php

/**
 * Класс ридера заданий.
 */
class BatchJobWriter implements BatchJobWriterInterface {

  /**
   * Загрузка задания.
   *
   * @inheritdoc.
   */
  public function write(BatchJobInterface $job) {
    $context = array(
      'handler' => get_class($job),
      'arguments' => $job->getArguments(),
      'state' => $job->getState(),
    );

    // генерация идентификатора
    if (!$id = $job->getId()) {
      $job->setId($this->getId());
    }

    return db_merge('batch_job')
      ->key(array(
        'id' => $job->getId(),
      ))
      ->fields(array(
        'uid' => $this->getUid(),
        'timestamp' => time(),
        'context' => drupal_json_encode($context),
        'status' => $job->getStatus(),
      ))
      ->execute();
  }

  /**
   * Геттер идентификатора пользователя.
   *
   * @return int
   *   Контекст задания.
   */
  protected function getUid() {
    global $user;
    return isset($user->uid) ? $user->uid : 0;
  }

  /**
   * Подготовка уникального идентификатора.
   *
   * @return string
   *   Идентификатор задания.
   */
  protected function getId() {
    return md5(uniqid(time(), TRUE));
  }

}
