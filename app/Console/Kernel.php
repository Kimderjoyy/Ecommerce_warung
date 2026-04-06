protected function schedule(Schedule $schedule)
{
    $schedule->command('orders:cancel-unpaid')->hourly();
}