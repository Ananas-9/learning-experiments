from django import forms
from django.forms.widgets import ClearableFileInput

from .models import ArticleImage

class ArticleImageForm(forms.ModelForm):
    image = forms.ImageField(widget=ClearableFileInput())
    class Meta:
        model = ArticleImage
        fields = '__all__'