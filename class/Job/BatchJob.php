<?php

/**
 * Прототип класса пакетного обработчика.
 */
abstract class BatchJob implements BatchJobInterface {
  protected $id;
  protected $status;
  protected $uid;
  protected $timestamp;
  protected $arguments;
  protected $state;

  /**
   * Конструктор класса.
   *
   * @param mixed $id
   *   Идентификатор батча.
   */
  public function __construct($id = NULL) {
    $this->id = $id;
    $this->status = 'initial';
    $this->arguments = array();
    $this->state = array(
      'total' => 0,
      'current' => 0,
      'message' => '',
    );
  }

  /**
   * Препроцесс батча.
   *
   * @inheritdoc
   */
  public function preprocess() {
    return $this;
  }

  /**
   * Постпроцесс батча.
   *
   * @inheritdoc
   */
  public function postprocess() {
    return $this;
  }

  /**
   * Геттер идентификатора.
   *
   * @inheritdoc
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Сеттер идентификатора.
   *
   * @inheritdoc
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Геттер аттрибутов.
   *
   * @inheritdoc
   */
  public function getArguments() {
    return $this->arguments;
  }

  /**
   * Сеттер аттрибутов.
   *
   * @inheritdoc
   */
  public function setArguments(array $arguments) {
    $this->arguments = $arguments;
    return $this;
  }

  /**
   * Геттер состояния.
   *
   * @inheritdoc
   */
  public function getState() {
    return $this->state;
  }

  /**
   * Сеттер состояния.
   *
   * @inheritdoc
   */
  public function setState(array $state) {
    $this->state = $state;
    return $this;
  }

  /**
   * Геттер статуса исполнения задания.
   *
   * @inheritdoc
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * Сеттер статуса исполнения задания.
   *
   * @inheritdoc
   */
  public function setStatus($status) {
    $this->status = $status;
    return $this;
  }

  /**
   * Геттер идентификатора пользователя.
   *
   * @inheritdoc
   */
  public function getUid() {
    return $this->uid;
  }

  /**
   * Сеттер идентификатора пользователя.
   *
   * @inheritdoc
   */
  public function setUid($uid) {
    $this->uid = $uid;
    return $this;
  }

  /**
   * Геттер временной метки.
   *
   * @inheritdoc
   */
  public function getTimestamp() {
    return $this->timestamp;
  }

  /**
   * Сеттер временной метки.
   *
   * @inheritdoc
   */
  public function setTimestamp($timestamp) {
    $this->timestamp = $timestamp;
    return $this;
  }

  /**
   * Текущий шаг.
   *
   * @inheritdoc
   */
  public function current() {
    return $this->state['current'];
  }

  /**
   * Процентное соотношение шагов.
   *
   * @inheritdoc
   */
  public function percent() {
    $result = 100;
    if ($total = $this->total()) {
      $result = floor(($this->current() * 100) / $this->total());
    }
    return $result;
  }

  /**
   * Сообщение о ходе обработки.
   *
   * @inheritdoc
   */
  public function message() {
    return $this->state['message'];
  }

  /**
   * Редирект по итогам исполнения.
   *
   * @inheritdoc
   */
  public function start() {
    $this->status = 'process';
    return $this;
  }

  /**
   * Общее количество шагов.
   *
   * @inheritdoc
   */
  public function total() {
    return $this->state['total'];
  }

  /**
   * Результаты на исполнения задания (футер).
   *
   * @inheritdoc
   */
  public function completeFooter() {
    return NULL;
  }

  /**
   * Редирект по итогам исполнения.
   *
   * @inheritdoc
   */
  public function redirect() {
    return NULL;
  }

  /**
   * Заголовок страницы.
   *
   * @inheritdoc
   */
  abstract public function title();

  /**
   * Описание страницы.
   *
   * @inheritdoc
   */
  abstract public function description();

  /**
   * Обработка задания.
   *
   * @inheritdoc
   */
  abstract public function process();

  /**
   * Результаты на исполнения задания.
   *
   * @inheritdoc
   */
  abstract public function complete();

}
