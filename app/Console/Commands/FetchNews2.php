<?php

namespace App\Console\Commands;

use Http;
use Illuminate\Console\Command;
use App\Models\Article;
use Illuminate\Support\Carbon;

class FetchNews2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news2 {category}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Fetching ' . $this->argument('category') . ' news...');

            $response = Http::get('https://content.guardianapis.com/search?tag=environment/recycling&api-key=test', [
                'api-key' => env('NEWS_API_KEY2'),
                'q' => $this->argument('category'),
            ]);

            if ($response->failed()) {
                $this->error('API request failed: ' . $response->status());
                return $this::FAILURE;
            }

            $data = $response->json()['response'];

            if (!isset($data['results']) || !is_array($data['results'])) {
                $this->error('Invalid response format: articles not found');
                return $this::FAILURE;
            }

            $count = 0;
            collect($data['results'])->each(function ($article) use (&$count) {
                try {
                    // Skip articles with no title or duplicate titles
                    if (Article::where('title', $article['webTitle'])->exists()
                        || $article['webTitle'] === null || $article['webTitle'] === '' || $article['webTitle'] === '[Removed]') {
                        return;
                    }

                    Article::create([
                        'title' => $article['webTitle'] ?? null,
                        'source' => 'The Guardian',
                        'category' => $article['sectionName'] ?? null,
                        'author' => $article['author'] ?? null,
                        'description' => $article['webUrl'] ?? null,
                        'content' => $article['apiUrl'] ?? null,
                        'published_at' => $article['webPublicationDate'] ? Carbon::parse($article['webPublicationDate']) : null,
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    $this->warn("Failed to save article: {$article['webTitle']} - {$e->getMessage()}");
                }
            });

            $this->info("Successfully imported {$count} articles");
            return $this::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error fetching news: ' . $e->getMessage());
            return $this::FAILURE;
        }
    }
}
