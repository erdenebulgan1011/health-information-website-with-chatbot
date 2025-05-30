<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Report - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .print-header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .print-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .print-header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .profile-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .profile-info {
            flex: 1;
        }
        .profile-info h2 {
            margin-top: 0;
        }
        .profile-photo {
            width: 150px;
            text-align: center;
        }
        .profile-photo img {
            max-width: 100%;
            border-radius: 50%;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            display: block;
            font-size: 13px;
            color: #666;
        }
        .info-value {
            font-size: 15px;
        }
        .stats-card {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .stats-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
        }
        .timeline {
            margin-top: 20px;
        }
        .timeline-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
        }
        .timeline-date {
            width: 120px;
            font-size: 12px;
            color: #666;
        }
        .timeline-content {
            flex: 1;
        }
        .timeline-badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 11px;
            border-radius: 3px;
            margin-right: 5px;
            background: #eee;
        }
        .badge-topic {
            background: #e3f2fd;
            color: #1976d2;
        }
        .badge-reply {
            background: #e8f5e9;
            color: #388e3c;
        }
        .badge-vr {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        .print-footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        @media print {
            body {
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
            .container {
                width: 100%;
                max-width: none;
                padding: 0;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="print-header">
            <h1>Professional Detailed Report</h1>
            <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
        </div>

        <div class="section">
            <div class="profile-details">
                <div class="profile-info">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                    <p>
                        <span class="info-label">Registration Date:</span>
                        {{ $professional->created_at->format('F d, Y') }}
                    </p>
                    <p>
                        <span class="info-label">Verification Status:</span>
                        <strong>{{ $professional->is_verified ? 'Verified' : 'Not Verified' }}</strong>
                    </p>
                </div>
                @if($user->profile && $user->profile->avatar)
                <div class="profile-photo">
                    <img src="{{ $user->profile->avatar }}" alt="{{ $user->name }}">
                </div>
                @endif
            </div>

            <div class="section-title">Professional Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Specialization</span>
                    <span class="info-value">{{ $profStats['specialization'] }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Qualification</span>
                    <span class="info-value">{{ $profStats['qualification'] }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Has Certification</span>
                    <span class="info-value">{{ $profStats['has_certification'] ? 'Yes' : 'No' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Is Doctor</span>
                    <span class="info-value">{{ $profStats['is_doctor'] ? 'Yes' : 'No' }}</span>
                </div>
            </div>
        </div>

        @if($doctorStats)
        <div class="section">
            <div class="section-title">Doctor Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Workplace</span>
                    <span class="info-value">{{ $doctorStats['workplace'] ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Years of Experience</span>
                    <span class="info-value">{{ $doctorStats['experience'] ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Education</span>
                    <span class="info-value">{{ $doctorStats['education'] ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Languages</span>
                    <span class="info-value">{{ $doctorStats['languages'] ?? 'Not specified' }}</span>
                </div>
            </div>
        </div>
        @endif

        <div class="section">
            <div class="section-title">Activity Statistics</div>

            <div class="stats-card">
                <div class="stats-title">Forum Topics</div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $topicStats['total'] }}</div>
                        <div class="stat-label">Total Topics</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $topicStats['views'] }}</div>
                        <div class="stat-label">Total Views</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $topicStats['pinned'] }}</div>
                        <div class="stat-label">Pinned Topics</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ number_format($topicStats['avg_replies'], 1) }}</div>
                        <div class="stat-label">Avg. Replies</div>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-title">Forum Replies</div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $replyStats['total'] }}</div>
                        <div class="stat-label">Total Replies</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $replyStats['best_answers'] }}</div>
                        <div class="stat-label">Best Answers</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $replyStats['parent_replies'] }}</div>
                        <div class="stat-label">Parent Replies</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $replyStats['child_replies'] }}</div>
                        <div class="stat-label">Child Replies</div>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-title">VR Content Suggestions</div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $vrContentStats['total'] }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $vrContentStats['pending'] }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $vrContentStats['approved'] }}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $vrContentStats['rejected'] }}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section page-break">
            <div class="section-title">Activity Timeline</div>
            <div class="timeline">
                @foreach($activityTimeline->take(15) as $activity)
                <div class="timeline-item">
                    <div class="timeline-date">
                        {{ $activity['date']->format('M d, Y') }}
                    </div>
                    <div class="timeline-content">
                        @if($activity['type'] == 'topic')
                            <span class="timeline-badge badge-topic">Topic</span>
                            {{ $activity['title'] }}
                        @elseif($activity['type'] == 'reply')
                            <span class="timeline-badge badge-reply">Reply</span>
                            To: {{ $activity['title'] }}
                        @elseif($activity['type'] == 'vr_suggestion')
                            <span class="timeline-badge badge-vr">VR Content</span>
                            {{ $activity['title'] }}
                            <small>({{ ucfirst($activity['status']) }})</small>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="print-footer">
            <p>Generated from Professionals Management System</p>
            <p>© {{ date('Y') }} Your Organization Name</p>
        </div>

        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print();" style="padding: 10px 20px; background: #2196f3; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Report
            </button>
            <a href="{{ route('admin.professionals.detail', $professional->id) }}" style="padding: 10px 20px; background: #757575; color: white; border: none; border-radius: 4px; text-decoration: none; margin-left: 10px;">
                Back to Details
            </a>
        </div>
    </div>
</body>
</html>
