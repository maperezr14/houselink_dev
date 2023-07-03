<?php
/**
 * Template Name: Template About Us
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
get_header();
the_post();
$id = get_the_ID();
$logo_banner = get_field("logo_banner");
$title_banner = get_field("title_banner");
$subtitle_banner = get_field("subtitle_banner");
?>
<section class="banner-ppal">
  <div class="content">
    <div class="image">
      <img src="<?php echo get_the_post_thumbnail_url();?>" alt="Houselink">
    </div>
    <div class="caption">
      <img class="logo_banner" src="<?php echo $logo_banner;?>" alt="Houselink">
      <h1><?php echo $title_banner; ?></h1>
      <p><?php echo $subtitle_banner; ?></p>
    </div>
  </div>
</section>

<?php 

$card_aboutus = get_field("card_aboutus", $id);
?>
<section class="cards-aboutus">
  <div class="content">
    <?php foreach ($card_aboutus as $cards) : ?>
      <?php
        $card_aboutus_image = $cards["card_aboutus_image"];
        $card_aboutus_content_title = $cards["card_aboutus_content_title"];
        $card_aboutus_content_text = $cards["card_aboutus_content_text"];
      ?>
      <div class="card-aboutus">
        <div class="card-aboutus_image">
          <img src="<?php echo $card_aboutus_image;?>" alt="Houselink">
        </div>      
        <div class="card-aboutus_content">
          <h3 class="card-aboutus_title"><?php echo $card_aboutus_content_title;?></h3>
          <?php echo $card_aboutus_content_text;?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php get_footer(); ?>