<?php

/**
 * Менеджер пакетных обработчиков.
 */
final class Batch {
  private static $cache;
  private static $factory;
  private static $reader;
  private static $writer;

  /**
   * Сеттер фабрики.
   *
   * @param BatchJobFactoryInterface $factory
   *   Объект фабрики.
   */
  public static function setFactory(BatchJobFactoryInterface $factory) {
    static::$factory = $factory;
  }

  /**
   * Сеттер ридера.
   *
   * @param BatchJobReaderInterface $reader
   *   Объект ридера.
   */
  public static function setReader(BatchJobReaderInterface $reader) {
    static::$reader = $reader;
  }

  /**
   * Сеттер ридера.
   *
   * @param BatchJobWriterInterface $writer
   *   Объект райтера.
   */
  public static function setWriter(BatchJobWriterInterface $writer) {
    static::$writer = $writer;
  }

  /**
   * Постановка задания.
   *
   * @param string $class
   *   Класс задания.
   * @param array $arguments
   *   (опционально) Массив аттрибутов.
   *
   * @return BatchJobInterface
   *   Объект задания.
   */
  public static function create($class, array $arguments = array()) {
    // подготовка ридера
    if (!static::$factory) {
      static::$factory = new BatchJobFactory();
    }

    $job = static::$factory->build($class, $arguments);
    static::set($job);

    return $job;
  }

  /**
   * Постановка задания и запуск исполнения.
   *
   * @param string $class
   *   Класс задания.
   * @param array $arguments
   *   (опционально) Массив аттрибутов.
   * @param string|null $redirect_path
   *   (опционально) Путь для редиректа после создания поручения.
   */
  public static function run($class, array $arguments = array(), $redirect_path = NULL) {
    if (!$redirect_path) {
      $redirect_path = 'batch_job';
    }

    drupal_goto(sprintf('%s/%s', rtrim($redirect_path, '/'), self::create($class, $arguments)->getId()));
  }

  /**
   * Постановка задания.
   *
   * @param string $id
   *   Идентификатор задания.
   *
   * @return BatchJobInterface
   *   Объект задания.
   */
  public static function get($id) {
    if (!isset(static::$cache[$id])) {
      // подготовка ридера
      if (!static::$reader) {
        static::$reader = new BatchJobReader();
      }

      // загрузка задания
      static::$cache[$id] = static::$reader->read($id);
    }

    return static::$cache[$id];
  }

  /**
   * Обновление задания.
   *
   * @param BatchJobInterface $job
   *   Объект задания.
   *
   * @return mixed
   *   Результат операции.
   */
  public static function set(BatchJobInterface $job) {
    // подготовка райтера
    if (!static::$writer) {
      static::$writer = new BatchJobWriter();
    }

    return static::$writer->write($job);
  }

  /**
   * Состояние исполнения задания.
   *
   * @param BatchJobInterface $job
   *   Объект задания.
   */
  public static function process(BatchJobInterface $job) {
    // препроцессинг батча
    $job->preprocess();

    // инициализация таймера
    timer_start('batch_job_processing');

    // процессинг заданий
    while ($job->getStatus() == 'process' && timer_read('batch_job_processing') < variable_get('batch_job_time_limit', 1000)) {
      $job->process();
    }

    // постпроцессинг батча
    $job->postprocess();
  }

  /**
   * Состояние исполнения задания.
   *
   * @param BatchJobInterface $job
   *   Объект задания.
   *
   * @return mixed
   *   Результат операции.
   */
  public static function state(BatchJobInterface $job) {
    return array(
      'id' => $job->getId(),
      'total' => $job->total(),
      'current' => $job->current(),
      'percent' => $job->percent(),
      'message' => $job->message(),
      'status' => $job->getStatus(),
    );
  }

}
