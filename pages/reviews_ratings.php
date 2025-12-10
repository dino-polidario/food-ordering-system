<?php 
include '../includes/db.php'; 
include '../includes/header.php'; 
?>

<?php 
// --- STATIC MOCK DATA ---
$mockReviews = [
    [
        'id' => 1,
        'name' => "Raine Nudo",
        'rating' => 5,
        'comment' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable"
    ],
    [
        'id' => 2,
        'name' => "Bernard Polidario",
        'rating' => 5,
        'comment' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable"
    ],
    [
        'id' => 3,
        'name' => "Raine Nudo",
        'rating' => 4,
        'comment' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable"
    ],
    [
        'id' => 4,
        'name' => "Bernard Polidario",
        'rating' => 4,
        'comment' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable"
    ]
];

$ratingDistribution = [
    ['stars' => 5, 'percentage' => 70],
    ['stars' => 4, 'percentage' => 50],
    ['stars' => 3, 'percentage' => 40],
    ['stars' => 2, 'percentage' => 20],
    ['stars' => 1, 'percentage' => 15]
];

$averageRating = 4.5;
// --- END STATIC MOCK DATA ---

// Helper function to render stars
function render_stars($rating) {
    $output = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= round($rating)) {
            $output .= '<span class="star-filled">★</span>';
        } else {
            $output .= '<span class="star-empty">☆</span>';
        }
    }
    return $output;
}
?>

<section class="review-section">
    <div class="container">
        <h1 style="font-family: 'Feeling Passionate', cursive;">
            Review and Ratings
        </h1>

        <div class="rating-overview-grid">
            
            <div class="average-rating-display">
                <div class="score"><?php echo number_format($averageRating, 1); ?></div>
                <div class="star-rating-lg">
                    <?php echo render_stars($averageRating); ?>
                </div>
                <p style="color: var(--text-light);">Average Rating</p>
            </div>

            <div class="rating-distribution">
                <?php foreach($ratingDistribution as $dist): ?>
                    <div class="rating-bar-row">
                        <span><?php echo $dist['stars']; ?>★</span>
                        <div class="rating-bar-container">
                            <div
                                class="rating-bar-fill"
                                style="width: <?php echo $dist['percentage']; ?>%"
                            ></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="reviews-list-container">
            <h2 style="font-size: 2rem; margin-bottom: 2rem;">Reviews</h2>
            <div class="space-y-6">
                <?php foreach($mockReviews as $review): ?>
                    <div class="review-card">
                        <div class="review-avatar">
                            <i class="material-icons">person</i>
                        </div>

                        <div class="review-content">
                            <h3 class="text-xl mb-2"><?php echo htmlspecialchars($review['name']); ?></h3>
                            <div class="review-star-row">
                                <?php echo render_stars($review['rating']); ?>
                            </div>
                            <p class="review-comment"><?php echo htmlspecialchars($review['comment']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="review-form-grid">
            <div style="grid-column: 1 / -1;">
                <h2 style="font-size: 2rem; margin-bottom: 2rem;">Leave Your Rating</h2>
            </div>
            
            <div>
                <label>Comments</label>
                <textarea
                    class="form-control"
                    placeholder="Write your review..."
                    disabled 
                ></textarea>
                <p style="font-size: 0.8rem; color: #E74C3C; margin-top: 5px;">*This form is non-functional in the current version.</p>
            </div>

            <div>
                <label>Rating</label>
                <div class="review-rating-input">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <button type="button" disabled>
                            <span class="review-star-lg <?php echo ($i <= 5) ? 'star-filled' : 'star-empty'; ?>">★</span>
                        </button>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>