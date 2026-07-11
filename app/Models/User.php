<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'google_id', 'google_token', 'subscription_ends_at', 'active_plan_id', 'next_plan_id'])]
#[Hidden(['password', 'remember_token', 'google_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subscription_ends_at' => 'datetime',
        ];
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function topicIdeas()
    {
        return $this->hasMany(TopicIdea::class);
    }

    public function getPlanLimits(): array
    {
        // If admin, unlimited
        if ($this->role === 'admin') {
            return [
                'projects' => 999999,
                'prompts' => 999999,
                'name' => 'Admin'
            ];
        }

        // Check if subscription has expired
        $isPremium = $this->role === 'premium' && $this->subscription_ends_at && $this->subscription_ends_at->isFuture();

        if (!$isPremium || !$this->active_plan_id) {
            // Free tier limits (Trial)
            return [
                'projects' => 1, // 1 project allowed for trial
                'prompts' => 2,  // 2 prompts allowed for trial
                'name' => 'Free Trial'
            ];
        }

        $plan = \App\Models\SubscriptionPlan::find($this->active_plan_id);
        if (!$plan) {
            return [
                'projects' => 1,
                'prompts' => 2,
                'name' => 'Free Trial'
            ];
        }

        $name = strtolower($plan->name);
        if (str_contains($name, 'basic')) {
            return [
                'projects' => 1,
                'prompts' => 5,
                'name' => 'Basic'
            ];
        } elseif (str_contains($name, 'bulanan')) {
            return [
                'projects' => 3,
                'prompts' => 20,
                'name' => 'Premium Bulanan'
            ];
        } elseif (str_contains($name, 'tahunan')) {
            return [
                'projects' => 999999,
                'prompts' => 999999,
                'name' => 'Premium Tahunan'
            ];
        } elseif (str_contains($name, 'campus')) {
            return [
                'projects' => 999999,
                'prompts' => 999999,
                'name' => 'Campus'
            ];
        }

        // Fallback default
        return [
            'projects' => 1,
            'prompts' => 5,
            'name' => $plan->name
        ];
     }

     public function getUsedPromptsCount(): int
     {
         return \Illuminate\Support\Facades\DB::table('ai_usages')
             ->where('user_id', $this->id)
             ->whereMonth('created_at', now()->month)
             ->whereYear('created_at', now()->year)
             ->count();
     }

     public function canUseAi(): bool
     {
         if ($this->role === 'admin') {
             return true;
         }

         $limits = $this->getPlanLimits();
         if ($limits['prompts'] >= 999999) {
             return true;
         }

         return $this->getUsedPromptsCount() < $limits['prompts'];
     }

     public function canCreateProject(): bool
     {
         if ($this->role === 'admin') {
             return true;
         }

         $limits = $this->getPlanLimits();
         if ($limits['projects'] >= 999999) {
              return true;
         }

         return $this->projects()->count() < $limits['projects'];
     }

     public function recordAiUsage(string $actionType): void
     {
         \Illuminate\Support\Facades\DB::table('ai_usages')->insert([
             'user_id' => $this->id,
             'action_type' => $actionType,
             'created_at' => now(),
             'updated_at' => now()
         ]);
     }
}
