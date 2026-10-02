from django.test import TestCase
from django.urls import reverse

from app_blog.models import Category, Article


class HomeTests(TestCase):
    def test_home_view_status_code(self):
        url = reverse('home')
        response = self.client.get(url)
        self.assertEqual(response.status_code, 200)


class CategoryTest(TestCase):
    @classmethod
    def setUpTestData(cls):
        Category.objects.create(category='Печиво', slug='pechivo')

    def test_articles_category_list_status_code(self):
        url = reverse('articles-category-list', kwargs={'slug': 'pechivo'})
        response = self.client.get(url)
        self.assertEqual(response.status_code, 200)


class ArticleTest(TestCase):
    @classmethod
    def setUpTestData(cls):
        cat1 = Category.objects.create(category='pechivo', slug='pechivo')
        Article.objects.create(category=cat1, title='Рецепт смачного печива', slug='recept-smachnogo-pechiva', pub_date='2020-01-01', main_page=False, description="Інгредієнти 1 2 3 4 5")

    def test_articles_list_status_code(self):
        url = reverse('articles-list')
        response = self.client.get(url)
        self.assertEqual(response.status_code, 200)

    def test_article_detail_status_code(self):
        url = reverse('article-detail', kwargs={'slug': 'recept-smachnogo-pechiva', 'year': '2020', 'month': '01', 'day': '01'})
        response = self.client.get(url)
        self.assertEqual(response.status_code, 200)