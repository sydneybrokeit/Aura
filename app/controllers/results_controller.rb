class ResultsController < ApplicationController
  helper_method :generateBarcode
  helper_method :base64_image
  require 'rmagick'
  require 'chunky_png'
  require 'barby/barcode/code_128'
  require 'barby/outputter/rmagick_outputter'
  require 'barby'
  def search
      @skus = []
      Sku.all.each do |sku|
          @skus.push(JSON.parse(sku.json))
      end
  end

  def base64_image(image_data)
      "<img src='data:image/png;base64,#{image_data}' />".html_safe
  end

  def generateBarcode(sku)
      barcode = Barby::Code128B.new(sku)
      @img = barcode.to_image
      @img.format = 'png'
      Base64.encode64(@img.to_blob).gsub(/\n/, "")
  end
end
