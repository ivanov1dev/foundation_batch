<?php

/**
 * Интерфейс фабрики пакетных обработчиков.
 */
interface BatchJobFactoryInterface {

  /**
   * Подготовка задания.
   *
   * @param string $handler
   *   Тип/имя класса обработчика.
   * @param array $arguments
   *   (опционально) Массив аргументов.
   *
   * @return BatchJobInterface
   *   Объект задания.
   */
  public function build($handler, array $arguments = array());

}
