<?php

/**
 * Интерфейс пакетного обработчика.
 */
interface BatchJobInterface {

  /**
   * Геттер идентификатор задания.
   *
   * @return string
   *   Идентификатор задания.
   */
  public function getId();

  /**
   * Сеттер идентификатора задания.
   *
   * @param string $id
   *   Идентификатор задания.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function setId($id);

  /**
   * Геттер атрибутов задания.
   *
   * @return array
   *   Массив аттрибутов.
   */
  public function getArguments();

  /**
   * Сеттер атрибутов задания.
   *
   * @param array $state
   *   Массив данных состояния.
   *
   * @return string
   *   Наименование инструмента.
   */
  public function setArguments(array $state);

  /**
   * Геттер состояния.
   *
   * @return string
   *   Наименование инструмента.
   */
  public function getState();

  /**
   * Сеттер данных состояния задания.
   *
   * @param array $state
   *   Массив данных состояния.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function setState(array $state);

  /**
   * Геттер статуса исполнения задания.
   *
   * @return string
   *   Статус исполнения задания.
   */
  public function getStatus();

  /**
   * Сеттер статуса исполнения задания.
   *
   * @param string $status
   *   Статус исполнения задания.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function setStatus($status);

  /**
   * Геттер идентификатора пользователя.
   *
   * @return int
   *   Идентификатор пользователя.
   */
  public function getUid();

  /**
   * Сеттер идентификатора пользователя.
   *
   * @param int $uid
   *   Идентификатор пользователя.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function setUid($uid);

  /**
   * Геттер временной метки.
   *
   * @return int
   *   Временная метка.
   */
  public function getTimestamp();

  /**
   * Сеттер временной метки.
   *
   * @param int $timestamp
   *   Временная метка.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function setTimestamp($timestamp);

  /**
   * Инициализация задания.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function start();

  /**
   * Обработка задания.
   *
   * @return BatchJobInterface
   *   Текущий объект.
   */
  public function process();

  /**
   * Результаты исполнения задания.
   *
   * @return string
   *   Отчет об исполнении задания.
   */
  public function complete();

  /**
   * Результаты на исполнения задания (футер).
   *
   * @return string
   *   Футер для кастомизации.
   */
  public function completeFooter();

  /**
   * Заголовок страницы.
   *
   * @return string
   *   Заголовок страницы.
   */
  public function title();

  /**
   * Описание страницы.
   *
   * @return string
   *   Описание страницы.
   */
  public function description();

  /**
   * Общее количество шагов.
   *
   * @return int
   *   Численное значение.
   */
  public function total();

  /**
   * Текущий шаг.
   *
   * @return int
   *   Численное значение.
   */
  public function current();

  /**
   * Процентное соотношение шагов.
   *
   * @return int
   *   Численное значение.
   */
  public function percent();

  /**
   * Сообщение о ходе обработки.
   *
   * @return string
   *   Содержимое сообщения.
   */
  public function message();

  /**
   * Редирект по итогам исполнения.
   *
   * @return mixed
   *   Ответ не определен.
   */
  public function redirect();

  /**
   * Препроцесс батча.
   *
   * @return self
   *   Текущий объект.
   */
  public function preprocess();

  /**
   * Постпроцесс батча.
   *
   * @return self
   *   Текущий объект.
   */
  public function postprocess();

}
