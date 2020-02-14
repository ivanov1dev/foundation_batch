<?php

/**
 * Класс файбрики пакетных обработчиков.
 */
class BatchJobFactory {

  /**
   * Подготовка задания.
   *
   * @inheritdoc
   */
  public function build($class, array $arguments = array()) {
    if ($class && !class_exists($class)) {
      $class = sprintf('BatchJob%s', $class);

      if (!class_exists($class)) {
        throw new \InvalidArgumentException(sprintf('Класс задания "%s" не найден', $class));
      }
    }

    $job = new $class();
    $job->setArguments($arguments);

    return $job;
  }

}
