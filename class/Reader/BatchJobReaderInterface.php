<?php

/**
 * Интерфейс класса ридера заданий.
 */
interface BatchJobReaderInterface {

  /**
   * Загрузка задания.
   *
   * @param string $id
   *   Идентификатор задания.
   *
   * @return BatchJobInterface
   *   Объект задания.
   */
  public function read($id);

}
