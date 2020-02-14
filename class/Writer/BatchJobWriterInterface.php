<?php

/**
 * Интерфейс класса райтера заданий.
 */
interface BatchJobWriterInterface {

  /**
   * Обновление задания.
   *
   * @param BatchJobInterface $job
   *   Объект задания.
   *
   * @return BatchJobInterface
   *   Объект задания.
   */
  public function write(BatchJobInterface $job);

}
