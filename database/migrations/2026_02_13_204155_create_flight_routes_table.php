    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flight_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('air_line_id')->constrained('air_lines');
            $table->foreignId('origin_airport_id')->constrained('airports');
            $table->foreignId('destination_airport_id')->constrained('airports');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['air_line_id', 'origin_airport_id', 'destination_airport_id'], 'flight_routes_unique_route');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_routes');
    }
};
