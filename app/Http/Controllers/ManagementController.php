<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Donation;
use App\Models\Purohit;

class ManagementController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        $recentDonations = Donation::latest()->take(5)->get()->map(function($donation) {
            return [
                'name' => $donation->name,
                'amount' => number_format($donation->amount, 0),
                'date' => $donation->date->format('M d, Y'),
                'status' => $donation->status === 'Completed' ? 'Confirmed' : $donation->status
            ];
        });

        return Inertia::render('Dashboard', [
            'recentDonations' => $recentDonations,
            'upcomingEvents' => [
                ['month' => 'Nov', 'day' => '05', 'title' => 'Deepavali Mahotsav', 'time' => '6:00 PM onwards'],
                ['month' => 'Nov', 'day' => '12', 'title' => 'Annapurna Puja', 'time' => 'All day event'],
                ['month' => 'Nov', 'day' => '18', 'title' => 'Karthik Purnima', 'time' => 'Evening Deepdan'],
            ]
        ]);
    }

    public function events()
    {
        $purohits = Purohit::all()->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name
            ];
        });

        return Inertia::render('Events', [
            'purohits' => $purohits,
            'events' => [
                ['month' => 'Mar', 'day' => '25', 'title' => 'Holi Maha Festival', 'type' => 'Festival', 'time' => '08:00 AM - 04:00 PM', 'purohit' => 'Pandit Rajesh Sharma', 'status' => 'Scheduled'],
                ['month' => 'Mar', 'day' => '22', 'title' => 'Daily Morning Aarti', 'type' => 'Daily Ritual', 'time' => '06:00 AM - 07:00 AM', 'purohit' => 'Pandit Om Prakash', 'status' => 'In Progress'],
                ['month' => 'Mar', 'day' => '21', 'title' => 'Evening Bhajan Sandhya', 'type' => 'Special Event', 'time' => '07:00 PM - 09:00 PM', 'purohit' => 'Smt. Meera Bai Group', 'status' => 'Completed'],
                ['month' => 'Apr', 'day' => '17', 'title' => 'Ram Navami Utsav', 'type' => 'Festival', 'time' => '10:00 AM - 02:00 PM', 'purohit' => 'Acharya Vinod Kumar', 'status' => 'Scheduled'],
            ]
        ]);
    }

    public function purohits()
    {
        $purohits = Purohit::all()->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'phone' => $p->phone,
                'email' => $p->email,
                'specialization' => $p->specialization,
                'experience' => $p->experience,
                'photo' => $p->photo
            ];
        });

        return Inertia::render('Purohits', [
            'purohits' => $purohits
        ]);
    }

    public function storePurohit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:purohits,phone',
            'email' => 'nullable|email|max:100',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
        ]);

        Purohit::create($validated);

        return redirect()->back()->with('success', 'Purohit added successfully.');
    }

    public function donations()
    {
        $donations = Donation::latest()->get()->map(function($donation) {
            return [
                'name' => $donation->name,
                'amount' => number_format($donation->amount, 2),
                'date' => $donation->date->format('M d, Y'),
                'method' => $donation->method,
                'status' => $donation->status
            ];
        });

        // Simple stats calculation
        $thisMonth = Donation::whereMonth('date', now()->month)->sum('amount');
        $thisYear = Donation::whereYear('date', now()->year)->sum('amount');
        $totalDonors = Donation::distinct('name')->count();

        return Inertia::render('Donations', [
            'stats' => [
                'thisMonth' => number_format($thisMonth, 0),
                'thisYear' => number_format($thisYear, 0),
                'totalDonors' => number_format($totalDonors, 0),
            ],
            'donations' => $donations
        ]);
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'method' => 'required|string',
            'status' => 'required|string',
        ]);

        Donation::create($validated);

        return redirect()->back()->with('success', 'Donation recorded successfully.');
    }

    public function volunteers()
    {
        return Inertia::render('Volunteers', [
            'stats' => [
                'totalVolunteers' => '1,240',
                'activeToday' => '85',
                'pendingRequests' => '12',
            ],
            'volunteers' => [
                [
                    'name' => 'Rahul Sharma',
                    'email' => 'rahul@email.com',
                    'phone' => '+91 98765 43210',
                    'skills' => ['Puja Setup'],
                    'task' => 'Evening Aarti',
                    'status' => 'Active',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCUOhnJ54ZW8sJkENeaYxF9KYgoTGRdikY0IJ9WRJMMTTbml433veLn5ON6dT0XLlSL9uRFObdZ7M-1T5YUc0ORcTavxxlfMRdSizyG5eFfmH8DlUwNWGv7gD0P21-AENkRmCpRawGHUih6onuMqWwrwnMxVVk-nZv68N2s0Z5p4rQCT5tOqUhn5hfEUF6hCScFk7AITyLyD0S87kRMlArpmbGOGtgXCPtWaXA7AtZh7F1q35fPgRU5N0l85r98doREY2jcCmlwIdiq'
                ],
                [
                    'name' => 'Priya Patel',
                    'email' => 'priya@email.com',
                    'phone' => '+91 87654 32109',
                    'skills' => ['Kitchen'],
                    'task' => 'Prasad Distribution',
                    'status' => 'Active',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuSpWybqlzagE8e7WS0PCbSFVqMPZjTz_amH7rszWK3ByQhjdH0wdq8H5pwpWDf0A8ihsni0vW4oU9ZlDFSwuWvNOyri8MFGm_v4YH9gli1x_RjUcLZ3GOex0vELNsngO5-XCJHd4Hzw1cS8Kl5gi9WwEsNPNTibGQI0cpM8jEM19DgiVoUSZK4mWPJR7OSL76BHtPHo9ZcaiN9D9Kv6omkKr38EqmOjI9lBvE7LEePL_tsDIUcyJbxQGN3hW-PPOIMgHkNJGS32b2o'
                ],
                [
                    'name' => 'Amit Singh',
                    'email' => 'amit@email.com',
                    'phone' => '+91 76543 21098',
                    'skills' => ['Crowd Control'],
                    'task' => 'Main Gate',
                    'status' => 'On Leave',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBLSROTNjiGVDjlQSbkqRN0B1umvlBpRqC2A1RzK0TnDvLlJ87fzrYpEOzMEYDhrlpqMXl9ns6CV8H69m7_iA4CVKIIfHpy7I8_uPaI3XvBfT6-UCR6iSSv7L6eA2_3AA7nGavtkNOqzvWRXpQ1GPtZSMyS7DHJdI21Z-pBCvZ0ABJePDft5MTF-Pyro4PAGyW5sZBe4zYbzeQ3i3Arayr4nBqyo_xepid7OypLTPWzuomVp3syAX0YgkHwWFUhYO1REnEczqHCF91C'
                ],
            ]
        ]);
    }

    public function assignVolunteers()
    {
        return Inertia::render('AssignVolunteers', [
            'event' => [
                'id' => 1,
                'title' => 'Maha Shivaratri Celebration',
                'date' => 'March 8, 2024',
                'location' => 'Main Temple Hall',
            ],
            'availableVolunteers' => [
                [
                    'id' => 10,
                    'name' => 'Rahul Sharma',
                    'skills' => ['Puja Setup', 'Flower Decoration', 'Prasad Management'],
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCDrfyXc3wJAgkxJh-PY1fqkhSYPq2vxafd3ROzT091T_W0IelC0q3v4kkfjTKjfFbdAjDkSttXm_wSX_rq74cmCiFmZFiPva21-GVbSSdVi3M9FGx19qI-OCdXRQB8ZI1wy0UIgNKOxDa1_Ej3NRb2sOVoG7LM6oxG1T6aZ2gZwlTZSWSNppBnLsuumouh3Uer84ptY8kCi712IP_91ue9WMCyiVJAlVTh_FAzIrC_tq0GdYv5mBUErTraJR4o2U6aqFEuvN8FHU59',
                ],
                [
                    'id' => 11,
                    'name' => 'Priya Patel',
                    'skills' => ['Crowd Control', 'First Aid', 'Registration'],
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBtthrSYbZ__KVgmpL0kO4JCOQzmtPdU38IHY59zg2b4aRQx_04KVgBV4lC2O-LHT6S-hh0F4-iUedQ5A_rYi6Q_4M9GyKu6TFVlLN4S-FO6ZrH1AWZZEhCG9dgj9LykabAtO6Sd-TGfgF_JxbyXck0CaxEHCBqb3g9riFJw9eN3y7WNVCgA0GtUGbdGgKdGMw822ZMnQ3uKWwqQdeh4INpeZJ5_0ATAkLi3s8yBojcsByaF31svQ2JA7YDvWXmnRHOI7St034B9vNO',
                ],
            ],
            'assignedVolunteers' => [
                [
                    'id' => 20,
                    'name' => 'Sneha Rao',
                    'role' => 'Decoration Lead',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDP1GrAPrRakI7Eng9yparuhPV_IgohEQmiW0aPy-37dyIdVWYUKAwbmFDubT5rq7FdqTkUFBYIHf3FEAMggFHrwa4psrAbiJavFeT2UxPWbyryJn7Kc3mquq81QTVQEYwfFwC0s0oPSvKCsvOCQDnfb5gKnMGqJsm3yUv8CehogcdWi9FmRdjbG4qV7yDYGvAvQg7uBrsg-6mpHB69vgQ_WmU8VO8mQS6AIrakh-9IMkkfzKdDtEgdKWeY1o8fnQyVASOASG_aN_Ib',
                ],
                [
                    'id' => 21,
                    'name' => 'Vikram Singh',
                    'role' => 'Security & Traffic',
                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBG6v20FTvNs-TBW5eWZBvf11saUyKTC7fkBJbL3S4CKkv9BTeRdbTkvhDafNnoRL2zqdaN-3-mqejt5WMhJPEYuge7I07ZxkCXFrTUFfL-cRE-0Do2Bag10Z3Q0apzCKhPeTpda3wIUqAFKQobEIvjp_n_0aWlOx8MZJewgIKYe1Frv0u9JJvpc-wQQbrB2Ys3JDS9wT9EjYBlWeDJn3ii5zXkmJkD0j3va2SBs5SD75YyxPpDNM1v1gfFJ-3gYBLCinhWSVOdnRx2',
                ],
            ]
        ]);
    }

    public function notificationLogs()
    {
        return Inertia::render('NotificationLogs', [
            'stats' => [
                'totalSent' => 45280,
                'successRate' => 98.4,
                'pendingRetries' => 12,
            ],
            'logs' => [
                [
                    'recipient' => 'Rajesh Kumar',
                    'contact' => '+91 98765 43210',
                    'typeIcon' => 'sms',
                    'event' => 'Monthly Abhishekam Invite',
                    'datetime' => 'Oct 24, 2023 · 09:15 AM',
                    'status' => 'Sent',
                ],
                [
                    'recipient' => 'Priya Sharma',
                    'contact' => 'priya.s@example.com',
                    'typeIcon' => 'mail',
                    'event' => 'Donation Receipt - #8892',
                    'datetime' => 'Oct 24, 2023 · 10:30 AM',
                    'status' => 'Sent',
                ],
                [
                    'recipient' => 'Amit Patel',
                    'contact' => 'Device ID: APP-9921',
                    'typeIcon' => 'notifications_active',
                    'event' => 'Navratri Special Darshan',
                    'datetime' => 'Oct 24, 2023 · 11:00 AM',
                    'status' => 'Pending',
                ],
                [
                    'recipient' => 'Meena Iyer',
                    'contact' => '+91 88776 65544',
                    'typeIcon' => 'sms',
                    'event' => 'Birthday Blessings',
                    'datetime' => 'Oct 24, 2023 · 06:00 AM',
                    'status' => 'Failed',
                ],
            ]
        ]);
    }

    public function notificationSettings()
    {
        return Inertia::render('NotificationSettings', [
            'settings' => [
                'auto_assignment_emails' => true,
                'schedule_change_alerts' => true,
                'reminder_notifications' => true,
                'first_reminder_timing' => '24h',
                'final_reminder_timing' => '1h',
                'delivery_methods' => ['Email', 'SMS'],
            ]
        ]);
    }

    public function profile()
    {
        return Inertia::render('Profile', [
            'admin' => [
                'name' => 'Vamsi Krishna',
                'email' => 'vamsi.krishna@temple.org',
                'phone' => '+91 98765 43210',
                'emergency_contact' => 'Priya Krishna (Wife) - +91 98765 00000',
                'address' => '12/A, Temple View Residency, Near Malleshwaram, Bengaluru, KA - 560003',
            ]
        ]);
    }
}
