<?php

/**
 * Интерфейс такетного обработчика.
 */
class BatchJobTest extends BatchJob implements BatchJobInterface {

  /**
   * Заголовок страницы.
   *
   * @inheritdoc
   */
  public function title() {
    return 'Тестовое задание';
  }

  /**
   * Описание страницы.
   *
   * @inheritdoc
   */
  public function description() {
    return 'Описание тестового задания';
  }

  /**
   * Инициализация задания.
   *
   * @inheritdoc
   */
  public function start() {
    parent::start();

    $this->state['total'] = rand(5000, 20000);
    return $this;
  }

  /**
   * Обработка задания.
   *
   * @inheritdoc
   */
  public function process() {
    usleep(rand(100, 500));

    $this->state['current'] = $this->state['current'] + 1;
    $this->state['message'] = 'Process #' . $this->state['current'];

    if ($this->state['current'] >= $this->state['total']) {
      $this->setStatus('complete');
    }

    return $this;
  }

  /**
   * Результаты на исполнения задания.
   *
   * @inheritdoc
   */
  public function complete() {
    return 'Processed ' . $this->state['total'] . ' items';
  }

}
